<div class="json-code" id="<?= $id?>">
    <div class="json-code-description">
        <?= $description ?>
    </div>
    <div class="json-code-url">
        <?= $url ?>
    </div>
    <div class="json-code-content">
        <div class="json-code-loader">

        </div>
    </div>
</div>
<script>
    handleJsonBody('<?= $id ?>', '<?= $url ?>', '<?= $method ?>', <?= $body ?>);
</script>