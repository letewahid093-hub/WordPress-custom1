<?php
/*
Template Name: All Events
*/

get_header(); ?>

<h1>All Events</h1>

<?php
$args = array(
    'post_type' => 'event',
    'posts_per_page' => -1, // show all events
    'orderby' => 'meta_value',
    'meta_key' => '_event_date',
    'order' => 'ASC'
);

$query = new WP_Query($args);

if($query->have_posts()) :
    while($query->have_posts()) : $query->the_post();
        $date = get_post_meta(get_the_ID(), '_event_date', true);
        $location = get_post_meta(get_the_ID(), '_event_location', true);
?>
<div class="event-item">

<?php if (has_post_thumbnail()) { ?>
    <?php the_post_thumbnail('medium'); ?>
<?php } ?>

<h2><?php the_title(); ?></h2>

<p>📅 <strong>Date:</strong> <?php echo esc_html($date); ?></p>

<p>📍 <strong>Location:</strong> <?php echo esc_html($location); ?></p>

<div><?php the_content(); ?></div>

</div>

<?php
    endwhile;
    wp_reset_postdata();
else :
    echo '<p>No events found.</p>';
endif;
?>
<?php get_footer(); ?>