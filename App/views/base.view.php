<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/main.js" ></script>
    <?php if (!isset($heads)):?>
        <title>Default</title>
    <?php else:?>
        <title><?php echo $heads['title']; unset($heads['title']) ?></title>
        <?php foreach ($heads as $head):?>
            <?= "<{$head}/>" ?>
        <?php endforeach?>
    <?php endif?>
</head>
<body>
    <?php loadPartial('navbar')?>
    <?= $body ?>
    <?php loadPartial('footer')?>
</body>
