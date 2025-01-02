<?php
  /**
    * Template Name: Home
  */

  get_header();
?>
    <div id="carousel" class="carousel slide used-cars-carousel" data-ride="carousel">
      <ol class="carousel-indicators">
        <?php 
          $carousel_items = get_field('carousel_images');
          if ($carousel_items):
            $index = 0;
            foreach ($carousel_items as $item): ?>
              <li data-target="#carousel" data-slide-to="<?php echo $index; ?>" class="<?php echo ($index == 0) ? 'active' : ''; ?>"></li>
              <?php $index++; endforeach;
          endif;
        ?>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner">
        <?php 
        if ($carousel_items):
          $index = 0;
          foreach ($carousel_items as $item): ?>
            <div class="item <?php echo ($index == 0) ? 'active' : ''; ?>">
              <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['image']['alt']); ?>">

              <!-- Overlay with Title and CTA -->
              <div class="carousel-caption-overlay">
                <h2><?php echo esc_html($item['title']); ?></h2>
                <a href="<?php echo esc_url($item['cta_url']); ?>">View Details</a>
              </div>
            </div>
            <?php $index++; endforeach; 
        endif; ?>
      </div>

      <!-- Left and right controls -->
      <a class="left carousel-control" href="#carousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

    <!-- Featured Car Section -->
    <div class="row featured car-listing-section">
      <div class="col-md-12">
        <h2>Featured Car of the Week</h2>
        <?php
          // Query cars with 'is_featured' checkbox selected
          $latest_cars = new WP_Query([
            'post_type' => 'car',
            'posts_per_page' => 6,
            'meta_query' => [
              [
                'key' => 'is_featured',
                'value' => '1',
                'compare' => '='
              ]
            ],
            'orderby' => 'date',
            'order' => 'DESC'
          ]);

          if ($latest_cars->have_posts()):
            while ($latest_cars->have_posts()): $latest_cars->the_post();
              // Get the 'on_sale' checkbox value
              $on_sale = get_field('on_sale');
        ?>
              <div class="col-md-12 padding-0">
                <div class="car-tile position-relative">
                  <!-- Display image -->
                  <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">

                  <!-- Display Sale Badge if 'on_sale' is checked -->
                  <?php if ($on_sale): ?>
                    <div class="sale-badge">Sale</div>
                  <?php endif; ?>

                  <h2><?php the_title(); ?></h2>
                  <?php the_content() ;?>
                  <button class="btn btn-info" data-toggle="modal" data-target="#carModal<?php the_ID(); ?>">View Details</button>
                </div>
              </div>
              <?php
            endwhile;
          else:
            echo '<p>No featured cars available this week.</p>';
          endif;
          wp_reset_postdata();
        ?>
      </div>
    </div>

    <!-- Car Listings Section -->
    <h2>Latest Cars</h2>
    <div class="row car-listing-section">
      <?php
        $car_query = new WP_Query([
          'post_type' => 'car',
          'posts_per_page' => 6
        ]);
        if ($car_query->have_posts()): 
          while ($car_query->have_posts()): $car_query->the_post();
            // Check if the car is on sale
            $is_on_sale = get_field('on_sale');
            $price = $is_on_sale ? get_field('sale_price') : get_field('price');
      ?>
            <div class="col-md-4">
              <div class="car-tile position-relative">
                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                <?php if ($is_on_sale): ?>
                  <span class="sale-badge">Sale</span>
                <?php endif; ?>
                <h4><?php the_title(); ?></h4>
                <p>Model: <?php the_field('car_model'); ?></p>
                <p>Engine: <?php the_field('engine_size'); ?>L</p>
                <p><strong>Price:</strong>
                  <?php if ($is_on_sale): ?>
                    <span class="strike">$<?php number_format(the_field('price')); ?></span> 
                    <span class="sale-price">$<?php number_format(the_field('sale_price')); ?></span>
                  <?php else: ?>
                    $<?php number_format(the_field('price')); ?>
                  <?php endif; ?>
                </p>
                <button class="btn btn-info" data-toggle="modal" data-target="#carModal<?php the_ID(); ?>">View Details</button>
              </div>
            </div>

            <!-- Modal for Car Details -->
            <div id="carModal<?php the_ID(); ?>" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php the_title(); ?></h4>
                  </div>

                  <div class="modal-body">
                    <!-- Display main car image -->
                    <?php $modal_id = get_the_ID(); ?>
                    <img src="<?php the_post_thumbnail_url(); ?>" 
                      alt="<?php the_title(); ?>" 
                      class="main-car-image" 
                      id="featured-image-<?php echo $modal_id; ?>"
                    />

                    <!-- Car Image Gallery -->
                    <?php
                      $car_gallery = get_field('image_gallery');
                      if ($car_gallery):
                    ?>
                        <div class="car-gallery">
                          <h4>Gallery</h4>
                          <div class="gallery-images">
                            <?php foreach ($car_gallery as $image): ?>
                              <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" 
                                data-full-image="<?php echo esc_url($image['url']); ?>" 
                                alt="<?php echo esc_attr($image['alt']); ?>" 
                                class="gallery-thumbnail" 
                                data-featured-id="featured-image-<?php echo $modal_id; ?>"
                              />
                            <?php endforeach; ?>
                          </div>
                        </div>
                    <?php endif; ?>

                    <?php the_content() ;?>

                    <!-- Display car details -->
                    <p><strong>Model:</strong> <?php the_field('car_model'); ?></p>
                    <p><strong>Engine Size:</strong> <?php the_field('engine_size'); ?>L</p>
                    <p><strong>Colour:</strong> <?php the_field('colour'); ?></p>
                    <p><strong>Price:</strong>
                      <?php if ($is_on_sale): ?>
                        <span class="strike">$<?php number_format(the_field('price')); ?></span> 
                        <span class="sale-price">$<?php number_format(the_field('sale_price')); ?></span>
                      <?php else: ?>
                        $<?php number_format(the_field('price')); ?>
                      <?php endif; ?>
                    </p>
                    <p><strong>No. of Seats:</strong> <?php the_field('seats'); ?></p>
                    <p><strong>Year of Manufacture:</strong> <?php the_field('year_of_manufacture'); ?></p>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile;
        endif;
        wp_reset_postdata();
      ?>

      <?php get_footer(); ?>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');

    thumbnails.forEach(thumbnail => {
      thumbnail.addEventListener('click', function () {
        const fullImageUrl = this.getAttribute('data-full-image');
        const featuredImageId = this.getAttribute('data-featured-id');
        const featuredImage = document.getElementById(featuredImageId);

        if (featuredImage) {
          featuredImage.src = fullImageUrl;
          featuredImage.alt = this.alt;
        }
      });
    });
  });
</script>

</body>
</html>