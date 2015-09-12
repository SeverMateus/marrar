<?php $ranking=true; ?>
@extends('layouts.maincontent')
@section('title')
    Lista de capitulos
@stop
@section('links')
@@parent
<link rel="stylesheet" href="{{URL::asset('expander/css/style.css')}}">
@stop
@section('body')
<div class="well">
<div align="center">
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    <script type="text/javascript">
        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>

    <h2 class="text-primary" >{{$disciplina->nome}}</h2>
    {!! Form::hidden('id',$disciplina->id,['id'=>'disciplina_id']) !!}

</div>
<script type="text/javascript">

    $(document).ready(function(){

        $.ajax({

            success: function() {

                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();

                } else {

                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    //

                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                        var albums = Mustache.to_html($('#capitulos').html(), JSON.parse(xmlhttp.responseText));

                        var details = Mustache.to_html($('#temas').html(),JSON.parse(xmlhttp.responseText));
                        $('.app-folders-container').html(albums + details);

                        $('.app-folders-container').appFolders({
                            opacity: 1,                 // Opacity of non-selected items
                            marginTopAdjust: true,            // Adjust the margin-top for the folder area based on row selected?
                            marginTopBase: 0,               // If margin-top-adjust is "true", the natural margin-top for the area
                            marginTopIncrement: 0,            // If margin-top-adjust is "true", the absolute value of the increment of margin-top per row
                            animationSpeed: 200,            // Time (in ms) for transitions
                            URLrewrite: true,               // Use URL rewriting?
                            URLbase: "./",            // If URL rewrite is enabled, the URL base of the page where used. Example (include double-quotes): "/services/"
                            internalLinkSelector: ".jaf-internal a"   // a jQuery selector containing links to content within a jQuery App Folder
                        });

                        // For each image:
                        // Once image is loaded, get dominant color and palette and display them.
                        $('.app-icon').bind('load', function (event) {
                            var image = event.target;
                            var $image = $(image);
                            var imageSection = $image.closest('.imageSection');

                            var colors = getColors(image);
                            styleBackground(colors[1], $image.parent().parent().attr('id'));
                            styleText(colors[1], colors[0], $image.parent().parent().attr('id'));
                        });

                    }


                }

                var windowWidth = window.innerWidth;
                var screenResolution=4;
                if(windowWidth<400)
                {
                    screenResolution=1;
                }
                else if(windowWidth<768)
                {
                    screenResolution=2;
                }

                else if(windowWidth<992){
                    screenResolution=3;

                }


             xmlhttp.open("GET", "capitulo-validacao/"+screenResolution, true);

                xmlhttp.send();

            }
        });
    });

</script>
<div class='app-icon' style="background-color: #000000;width: 20px;"></div>

<div class="app-folders-container">
    <script id="capitulos" type="text/x-mustache">
      @{{#data}}
        @{{#first}}
        <div class='jaf-row jaf-container'>
        @{{/first}}
          <div class='folder' id='@{{id}}'>
            <a href='#'>
              <img class='app-icon' src='expander/images/@{{image}}'>

              <p class='album-name'>@{{nome}}</p>
              </a>
          </div>
        @{{#last}}
          <br class='clear'>
        </div>
        @{{/last}}
      @{{/data}}

      </div>
    </script>

    <script id="temas" type="text/x-mustache">

      @{{#data}}
        <div class='folderContent @{{id}}'>
          <div class='jaf-container'>
            <div>
              <div class='art-wrap'>
                <img src='expander/images/@{{image}}'>
              </div>
              <h2 class="primaryColor">@{{nome}}</h2>
              <h3 class="secondaryColor">Lista de Temas</h3>
              <div class='multi'>
                <ol class="secondaryColor">
                  @{{#tema}}

                  <li><a href="exercicio/@{{id }}/@{{.}}"  class="primaryColor">@{{.}}</a></li>

                  @{{/tema}}

                </ol>
                </div>

            </div>

            <br class='clear'>
            <input type="hidden" value="/teste/@{{nome}}/@{{id}}" id="fazerTeste"/>
            <button onclick="document.location.href=document.getElementById('fazerTeste').value"><a href="teste/@{{nome}}/@{{id}}">Clique aqui para fazer o Teste</a></button>
          </div>
          <a href="#" class="close">&times;</a>
        </div>
      @{{/data}}
    </script>
</div>
</div>
<script src="expander/js/mustache.js"></script>
<script src="expander/js/jquery.app-folders.js"></script>
<script src="expander/js/quantize.js"></script>
<script src="expander/js/color-thief.js"></script>

@stop
