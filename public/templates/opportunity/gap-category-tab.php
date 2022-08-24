<?php
$response_body = nstxl_get_categories_opportunity($termID);
?>
<div class='polar-content section-space'>
    <!-- Blog Query  -->
    <div class="polar-posts polar-posts<?= $tab_num; ?>" data-tab="<?= $tab_num; ?>">
        <!-- the loop -->
        <?php
        if (empty($response_body)) {
          echo '<h4 style="text-align: center;font-size: 24px; font-weight: 900;color: #1b2549 !important;">' . __('Coming Soon', 'nstxl-opportunity') . '</h4>';
        } else {
          foreach ($response_body as $key => $value) {// echo '<pre>'. //print_r($value); echo '</pre>';
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
                            <?php if ($wordcount > 15) { ?> 
                              <a href='<?php echo esc_url($rlinks); ?>'><?php echo wp_trim_words($rshort_tilte, 15, '...'); ?></a>
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
                                <a class="events" href="<?php echo esc_url($rlinks); ?>#events-md"><img src="<?php echo nstxl_plugin_url; ?>/public/assets/images/Dates-and-events.png">Dates and Events</a>
                            </li>
                            <li>
                                <a class="keydoc" href="<?php echo esc_url($rlinks); ?>#keydocuments-md"><img src="<?php echo nstxl_plugin_url; ?>/public/assets/images/key-documents.png">Key Documents</a>
                            </li>
                            <li>
                                <a class="submitque" href="<?php echo esc_url($rlinks); ?>#submitquestion-md"><img src="<?php echo nstxl_plugin_url; ?>/public/assets/images/submit-a-question.png">Submit a Question</a>
                            </li>

                            <li>
                                <a class="submitproposal" href="<?php echo esc_url($rlinks); ?>#submitproposal-md"><img src="<?php echo nstxl_plugin_url; ?>/public/assets/images/submit-a-proposal.png">Submit a Proposal</a>
                            </li>
                            <li>
                                <a class="overview" href="<?php echo esc_url($rlinks); ?>#overview-md"><img src="<?php echo nstxl_plugin_url; ?>/public/assets/images/updates.png">Updates</a>
                            </li>
                            <li>
                                <a class="trackopr" href="<?php echo esc_url($rlinks); ?>#trackopportunity-md"><img src="<?php echo nstxl_plugin_url; ?>/public/assets/images/track-opportunity.png"><?php _e('Track Opportunity', 'nstxl-opportunity'); ?></a>
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
          <?php } //End of foreach  ?>
          <?php  ?>
          <div id="loadmores" class="loadmore wow animated fadeInUp text-center" style="clear:both;animation-name: fadeInUp">            
              <a class="btn btn-primary" href="#" data-page="2" data-perpage='6' data-tab="<?= $tab_num; ?>" data-opportunitytype="<?php echo $termID; ?>" >Load More</a>
          </div>   
        <?php  ?>
        <?php } //End of response_body is empty  ?>            
        <!-- End of Blog Query -->	

    </div>
</div>
