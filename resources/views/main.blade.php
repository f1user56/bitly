<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Сократи-ка ссылку</title>
    <meta name="description" content="Сокращалка ссылок">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" href="/favicon.ico" />
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-8">
            <h4> Сервис сокращения ссылок</h4>
                <label for="login">Ваша ссылка</label>
                <input type="text" name="url" id="url">
                <input type="submit" value="Сократить" style="background-color: cadetblue" class="btn" id="submit">
                <div class="alert alert-danger mt-2" id="errorBlock" style="display: none"></div>
                <div class="alert alert-success mt-2" id="shortLink" style="display: none"></div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    let url = ''
    let shortUrl = '';

    async function send(url) {
        const response = await fetch("/api/shortlink", {
            credentials: "same-origin",
            mode: "same-origin",
            method: "post",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({url: url})
        })
        const objResponse = await response.json()

        if (response.ok) {
            document.getElementById('shortLink').style = "display: block";
            document.getElementById('errorBlock').style = "display: none";
            document.getElementById('shortLink').textContent = "Your link: " + objResponse.short;
        } else {
            document.getElementById('shortLink').style = "display: none";
            document.getElementById('errorBlock').style = "display: block";
            document.getElementById('errorBlock').textContent = "Ошибка: " + objResponse.message;
        }
    }

    document.getElementById("url").addEventListener('input', e => {
        url = e.target.value
    })

    document.getElementById("submit").addEventListener('click', e => {
        send(url)
        e.preventDefault()
    }, false)
</script>
</html>
