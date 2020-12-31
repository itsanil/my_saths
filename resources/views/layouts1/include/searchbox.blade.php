 <div class="container-fluid">
        @if(!empty(Auth::user()) && Auth::user()->hasRole('admin'))
        @else
        <form class="form-group" id="search_form">
          <div class="input-group">
            <input type="hidden" id="search_type" name="search_type" value="product">
            @if(isset($name))
            @if($product_list->count() == 0)
                <?php $name = $name.' Products are coming Soon !!!';  ?>
            @endif
            <input class="form-control form-control-navbar" id="search" type="search" placeholder="Search for your products and brand here" aria-label="Search" value="<?php echo str_replace("_", " ", $name); ?>">
            @else
            <input class="form-control form-control-navbar" id="search" type="search" placeholder="Search for your products and brand here" aria-label="Search">
            @endif
            <ul class="typeahead dropdown-menu" role="listbox" style="display: block;width: 100%;">
              
            </ul>
            <div class="input-group-append">
              <button class="btn btn-danger" style="color: #ffffff;" type="submit">search
              </button>
            </div>
          </div>
        </form>
        @if(isset($cart) && isset($cart_count))
        <script>
          var product_id = '{{ $cart }}';
          var cart_count = parseInt('{{ $cart_count }}');
        </script>
        @endif
        @endif
      </div><!-- /.container-fluid -->
