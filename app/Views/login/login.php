<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title ?></title>
    </head>
    <body>
        <form action="<?php echo $action ?>" method="post" enctype="multipart/form-data">
            <h1>Login Form</h1>
            username : <input name="username" type="text"> <br>
            first name : <input name="first_name" type="text"> <br>
            last name : <input name="last_name" type="text"> <br>
            password : <input name="password" type="password"> <br>
            email : <input name="email" type="text"> <br><br>
            image : <input name="image" type="file"> <br><br><br><br>
            <input type="submit" value="login">
        </form>
    </body>
</html>