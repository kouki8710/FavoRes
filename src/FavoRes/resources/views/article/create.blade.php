<!DOCTYPE html>
<html>
    <head>
        <title>FavoRes | Create article</title>
        <meta charset="utf-8">
    </head>
    <body>
        
        <h1>Hello,world</h1>
        <form method="POST" action="/articles">
            @csrf
            <p>title</p>
            <input type="text" name="title">
            <p>content</p>
            <input type="text" name="content">
            <p>address</p>
            <input type="text" name="address">
            <input type="submit" value="send">
        </form>
    </body>
</html>