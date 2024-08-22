<?php
//Company's Proposal Layouts
$config['proposal_layouts'] = [
    'Cool' => 'cool',
    'Standard' => 'standard',
    'Gradient' => 'gradient',
    'Cool - No Totals' => 'cool2',
    'Standard - No Totals' => 'standard2',
    'Gradient - No Totals' => 'gradient2',
    'Cool - Lump Sum' => 'cool3',
    'Standard - Lump Sum' => 'standard3',
    'Gradient - Lump Sum' => 'gradient3'
];
//Old proposal Layout, for very very old proposals that we have to get rid of
$config['proposal_old_layouts'] = [
    'Standard' => 'html_1',
];

$config['lead_statuses'] = [
    'Working' => 'Working',
    'On Hold' => 'On Hold',
    'Waiting for Subs' => 'Waiting for Subs',
    'Cancelled' => 'Cancelled',
];

$config['prospect_statuses'] = [
    'Working' => 'Working',
    'Closed' => 'Closed',
    'Active' => 'Active',
    'Junk' => 'Junk',
];

$config['prospect_businesses'] = [
    'Apartments' => 'Apartments',
    'Driveway' => 'Driveway',
    'Home Owners Association (HOA)' => 'Home Owners Association (HOA)',
    'Condo Owners Association (COA)' => 'Condo Owners Association (COA)',
    'Hotel' => 'Hotel',
    'Industrial' => 'Industrial',
    'Municipal' => 'Municipal',
    'Restaurants' => 'Restaurants',
    'Retail' => 'Retail',
    'Shopping Center' => 'Shopping Center',
    'Tennis Courts' => 'Tennis Courts',
    'Commercial Management' => 'Commercial Management',
    'Industrial Management' => 'Industrial Management',
    'Other' => 'Other',
];

$config['lead_ratings'] = [
    'Platinium' => 'Platinium',
    'Gold' => 'Gold',
    'Silver' => 'Silver',
    'Unknown' => 'Unknown',
];

$config['prospect_ratings'] = [
    'Platinium' => 'Platinium',
    'Gold' => 'Gold',
    'Silver' => 'Silver',
    'Unknown' => 'Unknown',
];

$config['lead_sources'] = [
    'Existing Customer' => 'Existing Customer',
    'Advertisment' => 'Advertisment',
    'Cold Call' => 'Cold Call',
    'Employee Referral' => 'Employee Referral',
    'External Referral' => 'External Referral',
    'Partner' => 'Partner',
    'Seminar Partner' => 'Seminar Partner',
    'Seminar-Internal' => 'Seminar-Internal',
    'Trade Show' => 'Trade Show',
    'Web Research' => 'Web Research',
    'Chat' => 'Chat',
    'Direct Mail' => 'Direct Mail',
    'Email Blast' => 'Email Blast',
    'Jobsite/Truck Sign' => 'Jobsite/Truck Sign',
    'Website Search' => 'Website Search',
    'Yellow Pages' => 'Yellow Pages',
    'Bluebook' => 'Bluebook',
    'Unknown' => 'Unknown',
];

$config['service_pricing_types'] = [
    'Total Price' => 'Total',
    'Per Season' => 'Season',
    'Per Trip' => 'Trip',
    'Per Year' => 'Year',
    'Per Month' => 'Month',
    'Per Hour' => 'Hour',
    'No Pricing' => 'Noprice',
    'Materials Pricing' => 'Materials',
];

$config['materials'] = [
    'Ton' => 'Per Ton',
    'Bag' => 'Per Bag',
];

//key is the label - hour and am/pm generally and the value is the hour in the 24 hour format, with leading zeros
$config['leads_notification_intervals'] = [
    '11am' => 11,
    '3pm' => 15,
    '7pm' => 19,
];


$config['proposal_resend_times'] = [
    /*2 => ' 2 AM',
    3 => ' 3 AM',
    4 => ' 4 AM',
    5 => ' 5 AM',
    6 => ' 6 AM',
    7 => ' 7 AM',
    8 => ' 8 AM',*/
    9 => ' 9 AM',
    10 => '10 AM',
    11 => '11 AM',
    13 => ' 1 PM',
    14 => ' 2 PM',
    15 => ' 3 PM',
    16 => ' 4 PM',
];