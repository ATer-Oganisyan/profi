<?php global $result;?>
<html>
<head>
</head>
<body>
<form action="#" enctype="application/x-www-form-urlencoded" method="post">
    Имя: <input name="name" maxlength="50" value="<?=isset($result['request']['name'])?$result['request']['name']:""?>"/><br>
    Телефон: <textarea name="tel"><?=isset($result['request']['tel'])?$result['request']['tel']:""?></textarea><br>
    Описание заказа: <textarea name="descr"><?=isset($result['request']['descr'])?$result['request']['descr']:""?></textarea><br>
    <input type="submit" name="ok" value="ok"><br>
    <?php if (isset($result['result']['SQL']) && !isset($result['error'])) {?>
        SQL: <span><?=isset($result['result']['SQL'])?$result['result']['SQL']:""?></span><br><br>
    <?php } ?>

    <?php if (isset($result['result']['tel']) && !isset($result['error'])) {?>
        Tel:
        <ul>
<?php
foreach ($result['result']['tel'] as $tel) {
?>
            <li><?=$tel?></li>
<?php
}
?>
        </ul><br><br>
    <?php } ?>

    <?php if (isset($result['error'])) {?>
        SQL: <span style="color:red"><?=$result['error']?></span><br><br>
    <?php } ?>

</form>
</body>
</html>