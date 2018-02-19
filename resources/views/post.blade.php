<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $note->title.' - '.config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="/css/post.css">
</head>

<body>
    <div class="container">
    <article>
    <header class="post-header">
        <h1 class="post-title">{{$note->title}}</h1>
        <section class="post-meta">
            <span class="post-author">
                {{$note->author()->first()['name']}}
            </span>
             - 
            <time class="post-date">
                {{$note->created_at->toFormattedDateString()}}
            </time>
        </section>
    </header>
    <hr class="post-hr">

    <section class="post-content">
    {!! $noteParsed !!}
    </section>
    </article>
    <footer>
        <p>Publish by <a href="http://notesrepo.com">NotesRepo</a></p>
        <p>View source code on <a href="https://github.com/abowloflrf/notesrepo">GitHub</a></p>
    </footer>
    </div>
</body>

</html>
