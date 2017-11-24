@extends('layouts.app')

@section('content')

  <head>
    <title>Comentar</title>
  </head>
  <body>
    <div class="container">
    <h1 class="uk-text-center">Comentar en la publicación</h1>
      <div class="uk-overflow-auto">

        <a href="{{URL('home')}}"><button value="Volver" class="btn">Volver</button></a></p>
        <hr class='uk-grid-divider'>
        <div class="uk-overflow-auto">
          <table class="table">
            @if(count($Mostrar) > 0)
            <thead>
              <tr>
                <th>Publicación</th><th>Publicado por: </th><th>Votos</th><th>Comentarios</th>
              </tr>
            </thead>
            <tbody>
               @foreach($Mostrar->all() as $publicacion)
              <tr>
                <td><a href=http:\\{{$publicacion->link}} target='_blank'> {{ $publicacion->descripcion  }} </a></td>
                <td>{{$publicacion->name}}</td>
                <td><a class='glyphicon glyphicon-thumbs-up' href='{{url("/ValidarVoto/{$publicacion->id_publicacion}")}}'/> {{$publicacion->votos}}</td>
                <!--td><a class='glyphicon glyphicon-comment' href='{{url("/Comentarios/{$publicacion->id_publicacion}")}}'/> {{$publicacion->comentarios}}</td  DISQUS-->
                <td><a class='glyphicon glyphicon-comment' href='{{url("/Comentarios/{$publicacion->id_publicacion}")}}'/> Comentar</td>
              </tr>
              @endforeach
              @else
              @endif
            </tbody>

          </table>
        </div>
        @if(session('info'))
        <div class="alert alert-success">{{session('info')}}</div>
        @endif

      </div>
<!--
Omitido por DISQUS

    @guest
    Para interactuar con el contenido debe <a href="{{url('login')}}">Iniciar Sesión</a><br>
    @else

    <form class="uk-form uk-panel uk-panel-box" action="{{ url('SubirComentario') }}" method="POST"> {{csrf_field()}}
      <div class="uk-margin-large">
        <input type="hidden"  name="id_publicacion"   id="id_publicacion" value="{{$publicacion->id_publicacion}}" />
        <label class="uk-form-label uk-h3 ">Comentario:</label> <br>
        <textarea class="uk-width-1-1 uk-form-large" name="comentario" rows="6" required maxlength="10000" placeholder="Escriba su comentario aquí..."></textarea>
      </div>
      <button class ="uk-form-width-medium uk-button uk-button-primary uk-button-large" type="submit" value="Comentar" id="btnComentar" name="btnComentar">Comentar</button>
    </form>
    @endguest

          <div class="uk-container"><br>
            <h3>Comentarios anteriores: </h3>


            @if(count($MisPubs) > 0)
            @foreach($MisPubs->all() as $Show)
            <pre><p>{{$Show->name}} comentó: </p>{{$Show->comentario}}
            </pre><br>
            @endforeach
            @else
            @guest
            <h2>Esta muy solo por aquí, <a href="{{url('register')}}">registrese</a> para contribuir con el contenido.</h2>
            @else
            <h2>Aún no existen publicaciones. :'( </h2>
            @endguest
            @endif

          </div-->

<!--//DISQUS Añadido-->
          <div id="disqus_thread"></div>
          <script>

          /**
          *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
          *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
          /*
          var disqus_config = function () {
          this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
          this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
          };
          */
          (function() { // DON'T EDIT BELOW THIS LINE
          var d = document, s = d.createElement('script');
          s.src = 'https://webforo.disqus.com/embed.js';
          s.setAttribute('data-timestamp', +new Date());
          (d.head || d.body).appendChild(s);
          })();
          </script>
          <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>


        </div> <!--
        Div Container Principal
        Script de Disqus-->
        <script id="dsq-count-scr" src="//webforo.disqus.com/count.js" async></script>
    </body>
@endsection
