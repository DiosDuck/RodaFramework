<?php loadPartial("head", [
    'title' => 'Welcome page'
])?>
<main>
    <h1>Welcome!</h1>
    <?php loadPartial("json-code", [
        'id' => 'welcome-api',
        'description' => 'Welcome to the API',
        'url' => '/api/welcome',
        'method' => 'GET',
        'body' => '{}'
    ])?>
    <?php loadPartial("json-code", [
        'id' => 'json-body-api',
        'description' => 'This is an example of an endpoint that accepts a JSON body',
        'url' => '/api/json-body',
        'method' => 'POST',
        'body' => '{"name": "John Doe","email": "john.doe@email.com"}'
    ])?>
</main>
<?php loadPartial("footer")?>