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
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-8">
            <h4> Сервис сокращения ссылок</h4>
            <form action="/api/shortlink" method="post" class="mt-3">
                <label for="login">Ваша ссылка</label>
                <input type="text" name="url">
                <input type="submit" value="Сократить" style="background-color: cadetblue" class="btn">
                <?php if (!is_null($shortLink)): ?>
                <div class="alert alert-danger mt-2" id="errorBlock">Ваша короткая ссылка - {{$shortLink}}</div>
                <?php endif; ?>
                <?php if (!is_null($error)): ?>
                <div class="alert alert-danger mt-2" id="errorBlock">{{$error}}</div>
                <?php endif; ?>
                <?php if (!is_null($link)): ?>
                <div class="alert alert-success mt-2" id="errorBlock">Your Link: {{$link}}</div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
</body>
</html>
