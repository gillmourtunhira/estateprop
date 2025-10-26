<?php

/**
 * Property Block
 */

return [
    "key" => "crafted_layout_property_block",
    "name" => "property-block",
    "label" => "Property Block",
    "display" => "block",

    "sub_fields" => [
        [
            "key" => "crafted_layout_property_description_content",
            "name" => "description_content",
            "label" => "Description Content",
            "type" => "wysiwyg",
            "media_upload" => 0,
            "required" => 0,
        ],
        [
            "key" => "crafted_layout_property_suburb_address",
            "name" => "suburb_address",
            "label" => "Suburb Address",
            "type" => "text",
            "required" => 0,
            "wrapper" => [
                "width" => "50",
            ],
        ],
        [
            "key" => "crafted_layout_property_price",
            "name" => "price",
            "label" => "Price",
            "type" => "number",
            "required" => 0,
            "wrapper" => [
                "width" => "50",
            ],
        ],
        [
            "key" => "crafted_layout_property_details",
            "name" => "property_details",
            "label" => "Property Details",
            "type" => "repeater",
            "required" => 0,
            "min" => 1,
            "max" => 1,
            "layout" => "block",
            "button_label" => "Add Details",
            "sub_fields" => [
                [
                    "key" => "crafted_layout_property_gallery",
                    "name" => "gallery",
                    "label" => "Gallery",
                    "type" => "gallery",
                    "required" => 0,
                    "wrapper" => [
                        "width" => "100",
                    ],
                ],
                [
                    "key" => "crafted_layout_property_total_area_detail",
                    "name" => "total_area_detail",
                    "label" => "Total Area (sqm)",
                    "type" => "number",
                    "required" => 0,
                    "wrapper" => [
                        "width" => "25",
                    ],
                ],
                [
                    "key" => "crafted_layout_property_bedrooms_detail",
                    "name" => "bedrooms_detail",
                    "label" => "Bedrooms",
                    "type" => "number",
                    "required" => 0,
                    "wrapper" => [
                        "width" => "25",
                    ],
                ],
                [
                    "key" => "crafted_layout_property_bathrooms_detail",
                    "name" => "bathrooms_detail",
                    "label" => "Bathrooms",
                    "type" => "number",
                    "required" => 0,
                    "wrapper" => [
                        "width" => "25",
                    ],
                ],
                [
                    "key" => "crafted_layout_property_floor_detail",
                    "name" => "floor_detail",
                    "label" => "Floor",
                    "type" => "number",
                    "required" => 0,
                    "wrapper" => [
                        "width" => "25",
                    ],
                ],
                [
                    "key" => "crafted_layout_property_garages_detail",
                    "name" => "garages_detail",
                    "label" => "Garages",
                    "type" => "number",
                    "required" => 0,
                    "wrapper" => [
                        "width" => "25",
                    ],
                ],
                [
                    "key" => "crafted_layout_property_construction_year_detail",
                    "name" => "construction_year_detail",
                    "label" => "Construction Year",
                    "type" => "number",
                    "required" => 0,
                    "wrapper" => [
                        "width" => "25",
                    ],
                ],
                [
                    "key" => "crafted_layout_property_parking_detail",
                    "name" => "parking_detail",
                    "label" => "Parking",
                    "type" => "true_false",
                    "ui" => 1,
                    "ui_on_text" => "Yes",
                    "ui_off_text" => "No",
                    "required" => 0,
                    "wrapper" => [
                        "width" => "25",
                    ],
                ],
                [
                    "key" => "crafted_layout_property_wifi_detail",
                    "name" => "wifi_detail",
                    "label" => "Wifi",
                    "type" => "true_false",
                    "ui" => 1,
                    "ui_on_text" => "Yes",
                    "ui_off_text" => "No",
                    "required" => 0,
                    "wrapper" => [
                        "width" => "25",
                    ],
                ],
                [
                    "key" => "crafted_layout_property_cable_tv_detail",
                    "name" => "cable_tv_detail",
                    "label" => "Cable TV",
                    "type" => "true_false",
                    "ui" => 1,
                    "ui_on_text" => "Yes",
                    "ui_off_text" => "No",
                    "required" => 0,
                    "wrapper" => [
                        "width" => "25",
                    ],
                ],
            ],
        ],
        [
            "key" => "crafted_layout_property_map_coordinates_option",
            "name" => "map_coordinates_option",
            "type" => "true_false",
            "label" => "Map Option",
            "instructions" => "Toggle to use location coordinates or Google Maps",
            "ui" => 1,
            "ui_on_text" => "Coordinates",
            "ui_off_text" => "Map",
            "default_value" => "1",
        ],
        [
            "key" => "crafted_layout_property_map_longitude",
            "name" => "map_longitude",
            "label" => "Map Longitude",
            "type" => "text",
            "wrapper" => [
                "width" => "50",
            ],
            "required" => 0,
            "conditional_logic" => [
                [
                    [
                        "field" => "crafted_layout_property_map_coordinates_option",
                        "operator" => "==",
                        "value" => "1",
                    ],
                ],
            ],
        ],
        [
            "key" => "crafted_layout_property_map_latitude",
            "name" => "map_latitude",
            "label" => "Map Latitude",
            "type" => "text",
            "wrapper" => [
                "width" => "50",
            ],
            "required" => 0,
            "conditional_logic" => [
                [
                    [
                        "field" => "crafted_layout_property_map_coordinates_option",
                        "operator" => "==",
                        "value" => "1",
                    ],
                ],
            ],
        ],
        [
            "key" => "crafted_layout_property_google_map",
            "name" => "google_map",
            "label" => "Google Map",
            "type" => "google_map",
            "required" => 0,
            "conditional_logic" => [
                [
                    [
                        "field" => "crafted_layout_property_map_coordinates_option",
                        "operator" => "!=",
                        "value" => "1",
                    ]
                ]
            ]
        ],
        [
            "key" => "crafted_layout_property_agent_info",
            "name" => "agent_info",
            "label" => "Agent Info",
            "type" => "user",
            "role" => [
                "administrator",
                "editor",
                "agent",
            ],
            "return_format" => "array",
            "required" => 0,
        ],
    ],

    "min" => "1",
    "max" => "1",
];
