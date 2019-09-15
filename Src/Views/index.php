<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Žinutės</title>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/app.js"></script>
        <link rel="stylesheet" media="screen" type="text/css" href="css/screen.css" />
    </head>
    <body>
        <div id="wrapper">
            <h1>Jūsų žinutės</h1>
            <form message method="post" action="/">
                <input type="hidden" id="csrf" name="csrfToken" value="<?php echo $token ?? ''; ?>" />
                <p <?php echo isset($errors["fullname"]) ? 'class="err"' : ''; ?> >
                    <label for="fullname">Vardas, pavardė *</label><br/>
                    <input id="fullname" type="text" name="fullname" value="<?php echo $old["fullname"] ?? ''; ?>" />
                </p>
                <p  <?php echo isset($errors["birthdate"]) ? 'class="err"' : ''; ?> >
                    <label for="birthdate">Gimimo data *</label><br/>
                    <input id="birthdate" type="text" name="birthdate" value="<?php echo $old["birthdate"] ?? ''; ?>" />
                </p>
                <p <?php echo isset($errors["email"]) ? 'class="err"' : ''; ?> >
                    <label for="email">El.pašto adresas</label><br/>
                    <input id="email" type="text" name="email" value="<?php echo $old["email"] ?? ''; ?>" />
                </p>
                <p <?php echo isset($errors["message"]) ? 'class="err"' : ''; ?> >
                    <label for="message">Jūsų žinutė *</label><br/>
                    <textarea id="message" name="message"><?php echo $old["message"] ?? ''; ?></textarea>
                </p>
                <p>
                    <span>* - privalomi laukai</span>
                    <input type="submit" value="Skelbti" />
                    <img id="loader" src="img/ajax-loader.gif" alt="" style="display: none;"/>
                </p>
            </form>
            <ul>
                <li>
                    <strong>Šiuo metu žinučių nėra. Būk pirmas!</strong>
                </li>
                <div>
                <?php foreach ($data as $post) :?>

                    <li>
                        <span><?= (new DateTime($post["date"]))->format('Y m d H:i' ); ?></span>
                        <?php if ($post["email"]): ?>
                            <a href="mailto:<?= ($post["email"]); ?>"><?= ($post["fullname"]); ?></a>
                        <?php else: ?>
                            <?= ($post["fullname"]); ?></a>
                        <?php endif; ?>
                        ,
                        <?= timeAgo($post["date"]); ?><br/>
                        <?= htmlspecialchars($post["message"]); ?>
                    </li>

                <?php endforeach;?>
                </div>
            </ul>
            <p id="pages">
                <?= $paginator->navigate(); ?>
            </p>
        </div>
    </body>
</html>
