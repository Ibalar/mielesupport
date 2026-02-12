<?php
/**
 * Template Name: Test Services Catalog
 * Template for testing the services catalog block
 */

declare(strict_types=1);

get_header();
?>

<main class="test-services-catalog">
    <div class="container">
        <h1>Test Services Catalog Block</h1>
        
        <?php
        // Test data for the services catalog block
        $test_data = [
            'section_title' => 'Our Services',
            'service_categories' => [
                [
                    'category_title' => 'Appliance Repair',
                    'category_items' => [
                        [
                            'item_image' => [
                                'url' => 'https://via.placeholder.com/300',
                                'alt' => 'Refrigerator Repair'
                            ],
                            'item_title' => 'Refrigerator Repair',
                            'item_link' => [
                                'url' => '/services/refrigerator-repair/',
                                'title' => 'Refrigerator Repair'
                            ]
                        ],
                        [
                            'item_image' => [
                                'url' => 'https://via.placeholder.com/300',
                                'alt' => 'Washing Machine Repair'
                            ],
                            'item_title' => 'Washing Machine Repair',
                            'item_link' => [
                                'url' => '/services/washing-machine-repair/',
                                'title' => 'Washing Machine Repair'
                            ]
                        ],
                        [
                            'item_image' => [
                                'url' => 'https://via.placeholder.com/300',
                                'alt' => 'Dryer Repair'
                            ],
                            'item_title' => 'Dryer Repair',
                            'item_link' => [
                                'url' => '/services/dryer-repair/',
                                'title' => 'Dryer Repair'
                            ]
                        ]
                    ]
                ],
                [
                    'category_title' => 'Home Services',
                    'category_items' => [
                        [
                            'item_image' => [
                                'url' => 'https://via.placeholder.com/300',
                                'alt' => 'HVAC Service'
                            ],
                            'item_title' => 'HVAC Service',
                            'item_link' => [
                                'url' => '/services/hvac-service/',
                                'title' => 'HVAC Service'
                            ]
                        ],
                        [
                            'item_image' => [
                                'url' => 'https://via.placeholder.com/300',
                                'alt' => 'Plumbing Service'
                            ],
                            'item_title' => 'Plumbing Service',
                            'item_link' => [
                                'url' => '/services/plumbing-service/',
                                'title' => 'Plumbing Service'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        
        // Set the test data as query vars for the template part
        set_query_var('section_title', $test_data['section_title']);
        set_query_var('service_categories', $test_data['service_categories']);
        
        // Include the services catalog template
        get_template_part('template-parts/blocks/services-catalog');
        ?>
    </div>
</main>

<?php get_footer(); ?>