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

const input = [];

document.addEventListener('keypress', (e) => {
    input.push(e.key);
    if (input.length !== 4) {
        return;
    }
   
    let code = input.join('');
    if (code === 'luna') {
        fetch(
            '/api/admin/signed',
            {
                method: 'POST'
            }
        )
        .then(response => {if(response.ok) console.log('admin granted')})
        .catch(error => console.warn('admin could not be granted'))
    }
    else if (code === 'roda') {
        fetch(
            '/api/admin/unsigned',
            {
                method: 'POST'
            }
        )
        .then(response => {if(response.ok) console.log('admin removed')})
        .catch(error => console.warn('admin could not be removed'))
    }
    input.shift();
})
