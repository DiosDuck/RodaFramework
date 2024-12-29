function handleJsonBody(id, url, method, body) {
    let jsonCodeContent = document.getElementById(id).querySelector('.json-code-content');
    let init = {
        method: method
    }
    if (method !== 'GET') {
        init.body = JSON.stringify(body);
        init.headers = {
            'Content-Type': 'application/json'
        }
    }
    fetch(url, init)
    .then(response => response.json())
    .then(data => {
        jsonCodeContent.innerHTML = `<div class="json-code-response"><pre><code>${JSON.stringify(data, null, 2)}</code></pre></div>`;
    })
    .catch(error => {
        jsonCodeContent.innerHTML = 'Error fetching data';
        console.error('Error:', error);
    });
}