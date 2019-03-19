<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index</title>
</head>
<body>
  <form action="/generate.php" method="post">
      <label>Введите URL для сокращения</label>
      <input name="url" type="text">
      <label>Сокращенная ссылка</label>
      <input type="text" value="<?php echo $short_url; ?>" readonly="readonly">
      <button type="submit">Сократить</button>
  </form>
</body>
</html>