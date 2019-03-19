<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Table</title>
</head>
<body>
    <style type="text/css">
        .tftable {font-size:12px;color:#fbfbfb;width:100%;border-width: 1px;border-color: #686767;border-collapse: collapse;}
        .tftable th {font-size:12px;background-color:#171515;border-width: 1px;padding: 8px;border-style: solid;border-color: #686767;text-align:left;}
        .tftable tr {background-color:#2f2f2f;}
        .tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #686767;}
        .tftable tr:hover {background-color:#171515;}
        .record {color: #fbfbfb; text-decoration: none;}
        .record:hover {color: darkgrey; text-decoration: underline;}
    </style>

    <table class="tftable" border="1">
        <tr><th></th><th>Длинная ссылка</th><th>Короткая ссылка</th><th>Дата создания</th></tr>
        <?php foreach ($records as $record){ ?>
            <tr>
                <td> <input type="radio" form="betray" name="rec" value="<?php echo $record->id; ?>"> </td>
                <td>  <?php echo $record->long_url; ?>  </td>
                <td><?php echo $record->short_url; ?></td>
                <td>  <?php echo date('j-n-Y G:i', $record->date); ?>  </td>
            </tr>
        <?php } ?>
    </table>

    <form id="betray" method="post">
        <button type="submit" formaction="/delete.php" >Удалить</button>
        <button type="submit" formaction="/change.php" >Перегенерировать</button>
    </form>
</body>
</html>