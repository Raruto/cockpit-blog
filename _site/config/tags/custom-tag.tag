<!-- custom "uikit" tag -->
<custom-tag>

  <span></span>

  <script>

    this.on('mount', function() {
      this.update();
    });

    this.on('update', function(){
      this.root.innerHTML = 'It works!';
    });

    </script>

</custom-tag>
