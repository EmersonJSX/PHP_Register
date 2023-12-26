<?php
include('server.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['email']) || empty($_POST['senha'])) {
        echo ' &#128308; Preencha todos os campos';
    } else {
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $check_email = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
        $check_email->bind_param("s", $email);
        $check_email->execute();
        $check_result = $check_email->get_result();

        if ($check_result->num_rows > 0) {
            echo ' &#128308; Este email já está em uso';
        } else {
            // Insira o novo usuário
            $stmt = $mysqli->prepare("INSERT INTO users (email, senha) VALUES (?, ?)");
            $hashed_password = password_hash($senha, PASSWORD_DEFAULT);
            $stmt->bind_param("ss", $email, $hashed_password);

            if ($stmt->execute()) {
                echo ' &#128994; Conta criada com sucesso!';
            } else {
                echo ' &#128308; Falha ao criar conta. Tente novamente mais tarde.';
            }

            $stmt->close();
        }

        $check_email->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets\css\style.css">
    <title>Form</title>
</head>

<body>

    <main>
        <h1>Create account</h1>
        <form action="" method="POST">
            <p>
                Required fields are followed by
                <strong><span aria-label="required">*</span></strong>.
            </p>

            <section>
                <h2>Your info</h2>
                <p>
                    <label for="mail">
                        <span>Email: </span>
                        <strong><span aria-label="required">*</span></strong>
                    </label>
                    <input type="email" id="mail" name="email" required />
                </p>
                <p>
                    <label for="pwd">
                        <span>Password: </span>
                        <strong><span aria-label="required">*</span></strong>
                    </label>
                    <input type="password" id="pwd" name="senha" minlength="8" maxlength="32" required />
                </p>

                <button type="submit">Validate the payment</button>
            </section>
        </form>

    </main>
</body>

</html>