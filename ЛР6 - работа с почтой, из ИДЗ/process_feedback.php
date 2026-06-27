<?php
/**
 * Обработка формы обратной связи с PHPMailer
 */

// Путь к PHPMailer (файлы в папке src)
$phpmailer_dir = __DIR__ . '/PHPMailer/src/';

// Проверяем наличие файлов
if (file_exists($phpmailer_dir . 'PHPMailer.php')) {
    require_once $phpmailer_dir . 'Exception.php';
    require_once $phpmailer_dir . 'PHPMailer.php';
    require_once $phpmailer_dir . 'SMTP.php';
    $phpmailer_loaded = true;
} else {
    // Пробуем через composer
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/vendor/autoload.php';
        $phpmailer_loaded = true;
    } else {
        $phpmailer_loaded = false;
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Метод не разрешен']);
    exit();
}

$name = trim($_POST['fb-name'] ?? '');
$email = trim($_POST['fb-email'] ?? '');
$subject = trim($_POST['fb-subject'] ?? '');
$message = trim($_POST['fb-message'] ?? '');
$agree = isset($_POST['fb-agree']) ? true : false;

// Валидация
$errors = [];
if (empty($name)) $errors[] = 'Имя обязательно';
if (empty($email)) $errors[] = 'Email обязателен';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Неверный формат email';
if (empty($subject)) $errors[] = 'Тема обращения обязательна';
if (empty($message)) $errors[] = 'Сообщение обязательно';
if (strlen($message) < 10) $errors[] = 'Сообщение должно содержать минимум 10 символов';
if (!$agree) $errors[] = 'Необходимо согласие на обработку данных';

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit();
}

// Сохраняем в файл (бэкап)
$feedback_file = __DIR__ . '/feedback.json';
$feedback_data = [];
if (file_exists($feedback_file)) {
    $content = file_get_contents($feedback_file);
    if (!empty($content)) {
        $feedback_data = json_decode($content, true);
        if (!is_array($feedback_data)) {
            $feedback_data = [];
        }
    }
}

$new_feedback = [
    'id' => uniqid(),
    'name' => $name,
    'email' => $email,
    'subject' => $subject,
    'message' => $message,
    'created_at' => date('Y-m-d H:i:s'),
    'status' => 'new'
];

$feedback_data[] = $new_feedback;
file_put_contents($feedback_file, json_encode($feedback_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// ОТПРАВКА НА ПОЧТУ 
if ($phpmailer_loaded) {
    try {
        $mail = new PHPMailer(true);
        
        // Настройки SMTP
        $mail->SMTPDebug = SMTP::DEBUG_OFF;  // Для отладки: SMTP::DEBUG_SERVER
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';       // Для Gmail
        $mail->SMTPAuth = true;
        
       
        $mail->Username = 'ekaterinaovsanik7@gmail.com';  
        $mail->Password = 'kznx fxer uujr pjyt';         // Пароль приложения Gmail
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Отправитель и получатель
        $mail->setFrom('ekaterinaovsanik7@gmail.com', 'Izumi Market');
        $mail->addAddress('ekaterinaovsanik7@gmail.com');  // Кому отправляем
        
        // Ответить на email отправителя
        if (!empty($email)) {
            $mail->addReplyTo($email, $name);
        }
        
        // Содержимое письма
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "Обратная связь Izumi: $subject";
        
        $htmlBody = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; }
                .header { background: #7DB0D9; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                .field { margin-bottom: 15px; }
                .label { font-weight: bold; color: #555; }
                .value { padding: 10px; background: #f5f5f5; border-radius: 5px; margin-top: 5px; }
                .footer { text-align: center; padding: 20px; color: #999; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Новое сообщение с сайта Izumi</h2>
                </div>
                <div class='content'>
                    <div class='field'>
                        <div class='label'>Имя:</div>
                        <div class='value'>" . htmlspecialchars($name) . "</div>
                    </div>
                    <div class='field'>
                        <div class='label'>Email:</div>
                        <div class='value'>" . htmlspecialchars($email) . "</div>
                    </div>
                    <div class='field'>
                        <div class='label'>Тема:</div>
                        <div class='value'>" . htmlspecialchars($subject) . "</div>
                    </div>
                    <div class='field'>
                        <div class='label'>Сообщение:</div>
                        <div class='value'>" . nl2br(htmlspecialchars($message)) . "</div>
                    </div>
                </div>
                <div class='footer'>
                    Сообщение отправлено через форму обратной связи сайта Izumi
                </div>
            </div>
        </body>
        </html>
        ";
        
        $mail->Body = $htmlBody;
        $mail->AltBody = "Имя: $name\nEmail: $email\nТема: $subject\nСообщение: $message";
        
        $mail->send();
        
        echo json_encode([
            'success' => true,
            'message' => 'Сообщение успешно отправлено! Мы свяжемся с вами в ближайшее время.'
        ]);
        
    } catch (Exception $e) {
        // Ошибка отправки - но данные сохранены
        echo json_encode([
            'success' => true,
            'message' => 'Сообщение сохранено! Мы прочитаем его в ближайшее время.'
        ]);
    }
} else {
    // Если PHPMailer не загрузился - используем обычную mail()
    $to = "ekaterinaovsanik7@gmail.com";
    $email_subject = "Обратная связь Izumi: $subject";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: $email" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    
    $htmlBody = "
    <html>
    <body>
        <h2>Новое сообщение с сайта Izumi</h2>
        <p><strong>Имя:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Тема:</strong> $subject</p>
        <p><strong>Сообщение:</strong><br>$message</p>
    </body>
    </html>
    ";
    
    mail($to, $email_subject, $htmlBody, $headers);
    
    echo json_encode([
        'success' => true,
        'message' => 'Сообщение отправлено! Мы свяжемся с вами в ближайшее время.'
    ]);
}
?>