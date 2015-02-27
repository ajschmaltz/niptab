<script type="text/javascript">
  $(document).ready(function(){

    var update = function(){

      $.get( "ajax/test.html", function( data ) {
        $( "#result" ).html( data );
        alert( "Load was performed." );
      });

    };

    setInterval(function(){ update(); }, 3000);

  });
</script>