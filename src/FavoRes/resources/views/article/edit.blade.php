<!DOCTYPE html>
<html>
    <head>
        <title>FavoRes | Create article</title>
        <meta charset="utf-8">
    </head>
    <body>
        
        <h1>Hello,world</h1>
        <form method="POST" action="/articles/{{$article->id}}">
            @csrf
            @method('PUT')
            <p>title</p>
            <input type="text" name="title" value="{{$article->title}}">
            <p>content</p>
            <input type="text" name="content" value="{{$article->content}}">
            <p>address</p>
            <input type="text" name="address" value="{{$article->address}}">
            <input type="submit" value="send">
        </form>
        <form action="/articles/{{$article->id}}" method="POST">
            @csrf
            @method('DELETE')
            <p> 削除 </p>
            <input type="submit" value="delete">
        </form>
    </body>
</html>