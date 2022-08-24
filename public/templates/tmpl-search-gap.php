<?php
/*
 * Template Name: Search Opportunity
 */
get_header();
?>
<div class="polar-content  section-space polar-content-opportunities">
    <?php
    if (isset($_GET['sa']) && !empty($_GET['sa'])) {
      $keywords = $_GET['sa'];
    } else {
      $keywords = '';
    }
    $search_results = nstxl_search_opportunity($keywords);
    ?>
    <div class="container polar-content-container">
        <div class="search_header">        
            <div class="form-01">
                <?php $unique_id = esc_attr(uniqid('search-form-')); ?>
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>/search-opportunity">
                    <input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="<?php echo esc_attr_x('Search again', 'placeholder', 'polar'); ?>" value="<?php echo get_search_query(); ?>" name="sa" />
                    <button type="submit" class="search-submit"><i class="fa fa-search"></i><span class="screen-reader-text"><?php echo _x('Search', 'submit button', 'polar'); ?></span></button>
                </form>
            </div>
            <div class='search-title' style="">
                <h3 class='title'><?php printf(esc_html(_x('Search results for: "%s"', '%s - search keyword', 'polar')), "<span>" . esc_html($keywords) . "</span>"); ?></h3>
            </div>
        </div>


        <?php
        if (empty($search_results)) {
          echo '<h4>' . __('No Opportunity Found', 'nstxl-opportunity') . '</h4>';
        } else {
          ?>
          <div class='search-contents blog_search_contents clearfix'>
              <?php
              foreach ($search_results as $key => $value) {
                $rpost_id = $value->id;
                $rlinks = $value->link;
                $rtitle = $value->title->rendered;
                $rshort_tilte = $value->metadata->nstxl_short_title[0];
                $rfeatured_image_url = $value->featured_img_url;
                $opportunity_overview = $value->metadata->nstxl_overview[0];
                $opportunity_overview_count = str_word_count($opportunity_overview);
                $wordcount = str_word_count($rshort_tilte);
                ?>
                <div class="col-sm-6 col-md-6 wow animated fadeInUp item">
                    <article id="post-<?php echo $value->id; ?>" <?php echo post_class('polar-post polar-isotope-item') ?>>
                        <?php
                        if (!empty($rfeatured_image_url)) {
                          echo '<div class="featured-media"><a  rel="external nofollow" href="' . esc_url($rlinks) . '">';
                          echo '<img src="' . $rfeatured_image_url . '" />';
                          echo '</a></div>';
                        } else {
                          echo '<div class="featured-media"><a  rel="external nofollow" href="' . esc_url($rlinks) . '">';
                          echo '<img src="' . nstxl_plugin_url . '/public/assets/images/placeholder.png" />';
                          echo '</a></div>';
                        }
                        ?>
                        <div class="card-content">
                            <p class='post-title single-line-title'>
                                <?php if ($wordcount > 8) { ?> 
                                  <a href='<?php echo esc_url($rlinks); ?>'><?php echo wp_trim_words($rshort_tilte, 8, ''); ?></a>
                                <?php } else { ?>
                                  <a href='<?php echo esc_url($rlinks); ?>'><?php echo $rshort_tilte; ?></a>
                                <?php } ?>
                            </p>
                         <?php  $show_opportunity_overview = true; if($show_opportunity_overview) { ?>
                        <div class="opportunity-overview">                            
                            <?php if ($opportunity_overview_count > 15) { ?> 
                              <?php echo wp_trim_words($opportunity_overview, 15, ''); ?>
                            <?php } ?>
                        </div>
                        <?php } ?>
                           <?php $opportunityinfo = false; if($opportunityinfo){ ?>
                            <ul class="opporutnity-info-list">
                                <li>
                                    <a href="<?php echo esc_url($rlinks); ?>#events-md"><img src="<?php echo nstxl_plugin_url; ?>/public/assets/images/Dates-and-events.png">Dates and Events</a>
                                </li>
                                <li>
                                    <a href="<?php echo esc_url($rlinks); ?>#keydocuments-md"><img src="<?php echo nstxl_plugin_url; ?>/public/assets/images/key-documents.png">Key Documents</a>
                                </li>
                                <li>
                                    <a href="<?php echo esc_url($rlinks); ?>#submitquestion-md"><img src="<?php echo nstxl_plugin_url; ?>/public/assets/images/submit-a-question.png">Submit a Question</a>
                                </li>

                                <li>
                                    <a href="<?php echo esc_url($rlinks); ?>#submitproposal-md"><img src="<?php echo nstxl_plugin_url; ?>/public/assets/images/submit-a-proposal.png">Submit a Proposal</a>
                                </li>
                                <li>
                                    <a href="<?php echo esc_url($rlinks); ?>#overview-md"><img src="<?php echo nstxl_plugin_url; ?>/public/assets/images/updates.png">Updates</a>
                                </li>
                                <li>
                                    <a href="<?php echo esc_url($rlinks); ?>#trackopportunity-md"><img src="<?php echo nstxl_plugin_url; ?>/public/assets/images/track-opportunity.png"><?php _e('Track Opportunity', 'nstxl-opportunity'); ?></a>
                                </li>
                            </ul>
                           <?php } ?>
                          <?php $show_opportunity_morebutton = true; if($show_opportunity_morebutton) { ?>
                          <div id="morebutton" style="clear:both;animation-name: fadeInUp">            
                          <a class="btn btn-primary" href="<?php echo esc_url($rlinks); ?>">More Information</a>
                          </div>
                          <?php } ?>
                        </div>
                        <!-- the title, the content etc.. -->
                    </article>
                </div>
              <?php } // End of foreach ?>
          </div>
        <div id="loadmores" class="loadmore wow animated fadeInUp text-center" style="clear:both;animation-name: fadeInUp">            
              <a class="btn btn-primary" href="#" data-page="2" data-perpage='6' data-tab="1" data-keywords="<?= $keywords; ?>" >Load More</a>
        <?php } //End of search result condition   ?>
    </div>
</div>
<script type="text/javascript">
  var page = 2;  
  //var activepan;
  //var temptab;
  jQuery(function ($) {
    $(document).on('click', '.loadmore a', function (e) {
      e.preventDefault();
      this_save_to_remove = $(this);
      var keywords = $(this).attr('data-keywords');
      var per_page = $(this).attr('data-perpage');
      this_save_to_remove.prop('disabled', true);
      $(this).hide();
      $(this).parent(".loadmore").append("<div class='loadmore wow animated fadeInUp loadmoreloading btn btn-primary'> <img src='" + loademoreimg + "' /> Loading...</div>");
      var data = {
        'action': 'nstxl_loadmore_search_opportunity',
        'page': page,
        'keywords': keywords,
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
          var selectors = ".search-contents";          
          if (temptab_html != "" || temptab_html.length != 0) {
            $.each(temptab_html, function (key, val) {
              $('.search-contents').append(val);
            });
            page++;
            if($('.search-contents .item').length != response.data.xwptotalpages){
              var loadmorebtn = '<div id="loadmores" class="loadmore wow animated fadeInUp text-center" style="clear:both"><a  class="btn btn-primary" href="#" data-page="' + page + '" data-perpage="' + per_page + '" data-keywords="' + keywords + '" >Load More</a></div>';
              $('.search-contents').append(loadmorebtn);
            }
          } else {
            this_save_to_remove.parent(".loadmore").remove();
            page = 2;
            $(selectors).append('<div style="clear:both;font-size: 20px;font-weight: bold;" class="text-center">No more opportunity found</div>');
          }         
        },
      });
    });
  });
</script>
<?php
get_footer();
