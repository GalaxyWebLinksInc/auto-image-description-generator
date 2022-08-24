<?php
/*
 * Template Name: Opportunity with tab
 */
get_header();
?>
<div class='polar-content gray-back section-space polar-content-opportunities'>
    <div class="container polar-content-container">
        <div class='row'>
            <div class="form-01">
                <?php $unique_id = esc_attr(uniqid('search-form-')); ?>
                <form role="search" method="get" class="search-form opportunity-search" action="<?php echo esc_url(home_url('/')); ?>search-opportunity">
                    <input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="<?php echo esc_attr_x('Search', 'placeholder', 'nstxl-opportunity'); ?>" value="<?php echo get_search_query(); ?>" name="sa" />
                    <button type="submit" class="search-submit"><i class="fa fa-search"></i><span class="screen-reader-text"><?php echo _x('Search', 'submit button', 'nstxl-opportunity'); ?></span></button>
                </form>
            </div>
            <div id="opportunity-outer-tab" class="tab-opportunity-container container"> 
                <ul class="nav nav-pills">
                    <li class="active">
                        <a  href="#tab1a" data-toggle="tab"><?php _e('Coming Soon', 'nstxl-opportunity'); ?></a>
                    </li>
                    <li>
                        <a href="#tab2a" data-toggle="tab"><?php _e('Current', 'nstxl-opportunity'); ?></a>
                    </li>
                    <li>
                        <a href="#tab3a" data-toggle="tab"><?php _e('Closed', 'nstxl-opportunity'); ?></a>
                    </li>
                    <li>
                        <a href="#tab4a" data-toggle="tab"><?php _e('Awarded', 'nstxl-opportunity'); ?></a>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="tab1a" data-id="1">
                        <?php
                        $termID = 43;
                        $tab_num = 1;
                        include('opportunity/opportunity-category-tab.php');
                        ?>
                    </div>
                    <div class="tab-pane" id="tab2a" data-id="2">
                        <?php
                        $termID = 40;
                        $tab_num = 2;
                        ?>
                        <p class="joinnowlink"><a href="https://nstxl.org/join-now/">Become an member to submit proposal.</a> </p>
                        <?php
                        include('opportunity/opportunity-category-tab.php');
                        ?>
                    </div>
                    <div class="tab-pane" id="tab3a" data-id="3">
                        <?php
                        $termID = 44;
                        $tab_num = 3;
                        include('opportunity/opportunity-category-tab.php');
                        ?>
                    </div>
                    <div class="tab-pane" id="tab4a" data-id="4">
                        <?php
                        $termID = 41;
                        $tab_num = 4;
                        include('opportunity/opportunity-category-tab.php');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  var page = 2;
  var opportunitytype;
  var per_page;
  var activepan;
  var temptab;
  jQuery(function ($) {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      page = 2;
    });
    $(document).on('click', '.loadmore a', function (e) {
      e.preventDefault();
      this_save_to_remove = $(this);
      opportunitytype = $(this).attr('data-opportunitytype');
      per_page = $(this).attr('data-perpage');
      this_save_to_remove.prop('disabled', true);
      activepan = $(".tab-pane.active").data('id');
      temptab = $(this).data("tab");
      $(this).hide();
      $(this).parent(".loadmore").append("<div class='loadmore wow animated fadeInUp loadmoreloading btn btn-primary'> <img src='" + loademoreimg + "' /> Loading...</div>");
      var data = {
        'action': 'nstxl_loadmore_restopportunity',
        'page': page,
        'opportunitytype': opportunitytype,
        'per_page': per_page
      };
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        beforeSend: function () {
        
        },
        complete: function () {
          
        },
        success: function (response, textStatus, jqXHR) {
          this_save_to_remove.parent(".loadmore").remove();
          var temptab_html = response.data.data;
          var selectors = ".polar-posts" + temptab;
         // var rslenght = selectors+'  > .item';
          //alert(rslenght);
          if (activepan == temptab) {
            if (temptab_html != "" || temptab_html.length != 0) {              
              $.each(temptab_html, function (key, val) {
                $(selectors).append(val);
              });
              page++;
             // alert(rslenght.length);
             // if(rslenght != response.data.xwptotalpages){
                var loadmorebtn = '<div id="loadmores" class="loadmore wow animated fadeInUp text-center" style="clear:both"><a  class="btn btn-primary" href="#" data-page="' + page + '" data-tab="' + temptab + '" data-perpage="' + per_page + '" data-opportunitytype="' + opportunitytype + '" >Load More</a></div>';
                $(selectors).append(loadmorebtn);
              //}
            } else {
              this_save_to_remove.parent(".loadmore").remove();
              page = 2;
              $(selectors).append('<div style="clear:both;font-size: 20px;font-weight: bold;" class="text-center">No more opportunity found</div>');
            }
          }
        },
      });
    });
  });
</script>
<?php
get_footer();
