To implement a custom search that filters properties based on specific taxonomies like location, property type, and sale type, you'll need to create a custom search form and modify the query to include those taxonomies.

Here’s a step-by-step guide to help you set this up:

1. Create the Custom Search Form

You’ll need a custom search form that allows users to select filters based on location, property type, and sale type.

Add this form to your page template or wherever you want the search form to appear (typically in the sidebar or above the property listings).

Example Search Form:
<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="property-search">
        <!-- Search for properties -->
        <input type="text" name="s" placeholder="Search Properties" value="<?php echo get_search_query(); ?>" />

        <!-- Location Filter -->
        <select name="property_location">
            <option value="">Select Location</option>
            <?php 
                $locations = get_terms( array(
                    'taxonomy' => 'property_location',
                    'orderby'  => 'name',
                    'order'    => 'ASC',
                ) );
                foreach( $locations as $location ) {
                    echo '<option value="' . esc_attr( $location->term_id ) . '" ' . selected( isset( $_GET['property_location'] ) && $_GET['property_location'] == $location->term_id, true, false ) . '>' . esc_html( $location->name ) . '</option>';
                }
            ?>
        </select>

        <!-- Property Type Filter -->
        <select name="property_type">
            <option value="">Select Property Type</option>
            <?php 
                $property_types = get_terms( array(
                    'taxonomy' => 'property_type',
                    'orderby'  => 'name',
                    'order'    => 'ASC',
                ) );
                foreach( $property_types as $type ) {
                    echo '<option value="' . esc_attr( $type->term_id ) . '" ' . selected( isset( $_GET['property_type'] ) && $_GET['property_type'] == $type->term_id, true, false ) . '>' . esc_html( $type->name ) . '</option>';
                }
            ?>
        </select>

        <!-- Sale Type Filter -->
        <select name="property_status">
            <option value="">Select Sale Type</option>
            <?php 
                $statuses = get_terms( array(
                    'taxonomy' => 'property_status',
                    'orderby'  => 'name',
                    'order'    => 'ASC',
                ) );
                foreach( $statuses as $status ) {
                    echo '<option value="' . esc_attr( $status->term_id ) . '" ' . selected( isset( $_GET['property_status'] ) && $_GET['property_status'] == $status->term_id, true, false ) . '>' . esc_html( $status->name ) . '</option>';
                }
            ?>
        </select>

        <!-- Submit Button -->
        <button type="submit">Search</button>
    </div>
</form>

2. Modify the Search Query for Properties

You need to modify the WordPress search query to consider the custom taxonomy filters (like location, property type, and sale type) when performing the search.

Add this code in your functions.php file:

function buildexo_property_search_query( $query ) {
    if ( ! is_admin() && $query->is_search() && $query->is_main_query() ) {
        // Check if we're on the property search
        if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'property' ) {
            
            // Modify the query to include properties
            $query->set( 'post_type', 'property' );

            // Handle the Location Filter
            if ( isset( $_GET['property_location'] ) && ! empty( $_GET['property_location'] ) ) {
                $query->set( 'tax_query', array(
                    array(
                        'taxonomy' => 'property_location',
                        'field'    => 'id',
                        'terms'    => $_GET['property_location'],
                        'operator' => 'IN',
                    ),
                ));
            }

            // Handle the Property Type Filter
            if ( isset( $_GET['property_type'] ) && ! empty( $_GET['property_type'] ) ) {
                $query->set( 'tax_query', array(
                    array(
                        'taxonomy' => 'property_type',
                        'field'    => 'id',
                        'terms'    => $_GET['property_type'],
                        'operator' => 'IN',
                    ),
                ));
            }

            // Handle the Sale Type Filter (Status)
            if ( isset( $_GET['property_status'] ) && ! empty( $_GET['property_status'] ) ) {
                $query->set( 'tax_query', array(
                    array(
                        'taxonomy' => 'property_status',
                        'field'    => 'id',
                        'terms'    => $_GET['property_status'],
                        'operator' => 'IN',
                    ),
                ));
            }
        }
    }
}
add_action( 'pre_get_posts', 'buildexo_property_search_query' );

Explanation:

Search Form:

The form contains fields for Location, Property Type, and Sale Type, each linked to a custom taxonomy (property_location, property_type, property_status).

The user can select a taxonomy term for each of these fields.

Modifying the Query (pre_get_posts):

The pre_get_posts hook modifies the default search query when the user submits the custom search form.

The query is modified to include properties (post_type => property).

The tax_query part is added to filter by the selected terms in the taxonomies property_location, property_type, and property_status.

Search Action:

When the user submits the form, the search will return results only for properties, and will be filtered by the selected location, property type, and sale type.

3. Displaying the Search Results

You’ll also need to display the search results on your custom search page, which could look like the following:

<?php get_header(); ?>

<section class="property-results">
    <div class="container">
        <div class="row">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="col-lg-4">
                        <div class="property-item">
                            <a href="<?php the_permalink(); ?>">
                                <?php if ( has_post_thumbnail() ) { ?>
                                    <img src="<?php the_post_thumbnail_url( 'medium' ); ?>" alt="<?php the_title(); ?>">
                                <?php } ?>
                                <h4><?php the_title(); ?></h4>
                                <p><?php echo get_the_excerpt(); ?></p>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p><?php esc_html_e( 'No properties found.', 'buildexo' ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>


This template will display the search results for properties based on the filter criteria selected by the user.

4. Customize the Query Further (Optional)

You can also add additional filters, such as price ranges, number of bedrooms, or other custom fields (e.g., via meta queries).

You can add pagination to the search results by using paginate_links().

Conclusion:

With this approach, you create a custom property search form with filters based on custom taxonomies, and modify the query to include those filters. The custom search will now return only property posts, filtered by location, property type, and sale type.
