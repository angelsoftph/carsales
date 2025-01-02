<?php
/**
 * Search Results Template
 * Template Name: Search Results
 */

get_header(); ?>

<div class="search-results-page">
    <div class="container">
        <header class="search-header">
            <h2 class="search-title">
                <?php
                    printf(
                        esc_html__('Search Results for: %s', 'textdomain'),
                        '<span>' . get_search_query() . '</span>'
                    );
                ?>
            </h2>
        </header>

        <?php if (have_posts()) : ?>
            <div class="search-results">
                <div class="row car-listing-section">
                    <?php
                        while (have_posts()) :
                            the_post();

                            $is_on_sale = get_field('on_sale');
                            $price = get_field('price', 'option');
                            $sale_price = get_field('sale_price');
                    ?>
                            <div class="col-md-4">
                                <div class="car-tile position-relative">
                                    <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                                    <h4><?php the_title(); ?></h4>
                                    <p>Model: <?php the_field('car_model'); ?></p>
                                    <p>Engine: <?php the_field('engine_size'); ?>L</p>
                                    <?php if ($is_on_sale): ?>
                                        <span class="sale-badge">Sale</span>
                                        <p>Price: $<span class="strike"><?php the_field('price'); ?></span> $<?php the_field('sale_price'); ?></p>
                                    <?php else: ?>
                                        <p>Price: <?php the_field('price'); ?></p>
                                    <?php endif; ?>
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
                                        <?php
                                            endif;
                                        ?>

                                        <?php the_content() ;?>

                                        <!-- Display car details -->
                                        <p><strong>Model:</strong> <?php the_field('car_model'); ?></p>
                                        <p><strong>Engine Size:</strong> <?php the_field('engine_size'); ?>L</p>
                                        <p><strong>Colour:</strong> <?php the_field('colour'); ?></p>
                                        <p><strong>Price:</strong>
                                        <?php if ($is_on_sale): ?>
                                            <span class="strike">$<?php the_field('price'); ?></span> 
                                            <span class="sale-price">$<?php the_field('sale_price'); ?></span>
                                        <?php else: ?>
                                            $<?php the_field('$price'); ?>
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
                    <?php
                        endwhile;
                    ?>
                </div>

                <div class="pagination">
                    <?php
                        // Display pagination
                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'prev_text' => __('« Previous', 'textdomain'),
                            'next_text' => __('Next »', 'textdomain'),
                        ));
                    ?>
                </div>
            </div>
        <?php else : ?>
            <div class="no-results">
                <h2><?php esc_html_e('No Results Found', 'textdomain'); ?></h2>
                <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'textdomain'); ?></p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
