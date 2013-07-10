<html>
    <head></head>
    <body>
        <!--                {{ Form::open_for_files('testing', 'POST') }}{{ Form::token() }}
                        <p><input type="file" name="fileberkas"></p>
                        <p><input type="text" name="fileberkas"></p>
                        <p><input type="submit" name="submit" value="kirim"></p>
                        {{ Form::close() }}-->
        <audio controls>
            <source src="{{ URL::home() }}Maher Zain - Mawlaya.ogg" type="audio/ogg">
            <source src="{{ URL::home() }}Maher Zain - Mawlaya.mp3" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio> 
    </body>
</html>