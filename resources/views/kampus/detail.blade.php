@extends('layouts.front', ['title' => 'Kampus - MagangHub'])

@section('head')
    <style rel="stylesheet">
      body {
        background-image: url("{{ url('img/bg2.png') }}");
        background-position: center top;
        background-repeat: no-repeat;
        background-size: 100% 400px;
      }
      .panel {
        height: 110px;
        width: 100%;
      }
      .profile-text {
        float: left;
        height: auto;
        margin-top: 50px;
        /* position: relative; */
      }
      .profile-thumb {
        float: left;
        position: relative;
        width: 140px;
        height: 110px;
      }
      .profile-thumb img {
        position: absolute;
        max-width: 140px;
        max-height: 140px;
        bottom: -30px;
      }
      .fb-name  {
        /* bottom: 0;
        left: 140px;
        position: absolute; */
      }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ url('styles/card-carousel.css') }}">
@endsection

@section('content')
    <div class="panel px-2 px-lg-3">
        <div class="profile-thumb">
            <img src="{{ url('img/logo-ui.png') }}" class="bg-light border p-2 shadow-sm">
        </div>
        <div class="profile-text">
            <div class="fb-name ml-2">
                <h2 class="p-0 m-0">Universitas Indonesia</h2>
                <i><small>Menunggu verifikasi MagangHub</small></i>
            </div>
        </div>
    </div>

    <div class="bg-light shadow-sm border px-2 px-lg-3 pt-5 pb-3">
        <table>
            <tr valign="top">
                <td class="pb-3"><i class="fas fa-phone"></i></td>
                <td>(021) 123123</td>
            </tr>
            <tr valign="top">
                <td class="pb-3"><i class="fas fa-map-marker-alt"></i></td>
                <td>Jl. Margonda Raya, Pondok Cina, Kecamatan Beji, Kota Depok, Jawa Barat 16424</td>
            </tr>
        </table>
        <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
            <div class="MultiCarousel-inner">
                <div class="item">
                    <div class="pad15">
                        <p class="lead">Multi Item Carousel</p>
                        <p>₹ 1</p>
                        <p>₹ 6000</p>
                        <p>50% off</p>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary leftLst"><</button>
            <button class="btn btn-primary rightLst">></button>
        </div>
    </div>

@endsection

@section('bottom')
  <script>
    $(document).ready(function () {
      var itemsMainDiv = ('.MultiCarousel');
      var itemsDiv = ('.MultiCarousel-inner');
      var itemWidth = "";

      $('.leftLst, .rightLst').click(function () {
          var condition = $(this).hasClass("leftLst");
          if (condition)
              click(0, this);
          else
              click(1, this)
      });

      ResCarouselSize();




      $(window).resize(function () {
          ResCarouselSize();
      });

      //this function define the size of the items
      function ResCarouselSize() {
          var incno = 0;
          var dataItems = ("data-items");
          var itemClass = ('.item');
          var id = 0;
          var btnParentSb = '';
          var itemsSplit = '';
          var sampwidth = $(itemsMainDiv).width();
          var bodyWidth = $('body').width();
          $(itemsDiv).each(function () {
              id = id + 1;
              var itemNumbers = $(this).find(itemClass).length;
              btnParentSb = $(this).parent().attr(dataItems);
              itemsSplit = btnParentSb.split(',');
              $(this).parent().attr("id", "MultiCarousel" + id);


              if (bodyWidth >= 1200) {
                  incno = itemsSplit[3];
                  itemWidth = sampwidth / incno;
              }
              else if (bodyWidth >= 992) {
                  incno = itemsSplit[2];
                  itemWidth = sampwidth / incno;
              }
              else if (bodyWidth >= 768) {
                  incno = itemsSplit[1];
                  itemWidth = sampwidth / incno;
              }
              else {
                  incno = itemsSplit[0];
                  itemWidth = sampwidth / incno;
              }
              $(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
              $(this).find(itemClass).each(function () {
                  $(this).outerWidth(itemWidth);
              });

              $(".leftLst").addClass("over");
              $(".rightLst").removeClass("over");

          });
      }


      //this function used to move the items
      function ResCarousel(e, el, s) {
          var leftBtn = ('.leftLst');
          var rightBtn = ('.rightLst');
          var translateXval = '';
          var divStyle = $(el + ' ' + itemsDiv).css('transform');
          var values = divStyle.match(/-?[\d\.]+/g);
          var xds = Math.abs(values[4]);
          if (e == 0) {
              translateXval = parseInt(xds) - parseInt(itemWidth * s);
              $(el + ' ' + rightBtn).removeClass("over");

              if (translateXval <= itemWidth / 2) {
                  translateXval = 0;
                  $(el + ' ' + leftBtn).addClass("over");
              }
          }
          else if (e == 1) {
              var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
              translateXval = parseInt(xds) + parseInt(itemWidth * s);
              $(el + ' ' + leftBtn).removeClass("over");

              if (translateXval >= itemsCondition - itemWidth / 2) {
                  translateXval = itemsCondition;
                  $(el + ' ' + rightBtn).addClass("over");
              }
          }
          $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
      }

      //It is used to get some elements from btn
      function click(ell, ee) {
          var Parent = "#" + $(ee).parent().attr("id");
          var slide = $(Parent).attr("data-slide");
          ResCarousel(ell, Parent, slide);
      }

  });

  </script>
@endsection