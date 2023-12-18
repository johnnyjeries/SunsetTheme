<?php

/*
	
@package sunsettheme
	
	========================
		WALKER NAV CLASS
	========================
*/

class Sunset_Walker_Nav_Primary extends Walker_Nav_menu {
	
	function start_lvl( &$output, $depth = 0, $args = array() ){ //ul
        /* $output: & so we dont rewrite the info that is inside the output var, 
            $indent so we use tabs inside our html code  
        */
		$indent = str_repeat("\t",$depth);
        // detect if there is new level of indentation ( submenu items )
		$submenu = ($depth > 0) ? ' sub-menu' : '';
		$output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
	}
	
    // function manages the html markup of li a span
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){ //li a span
		// $output all information of html generated markup, $item contains all different elements inside the li which is the a tag and all the attributes of the a tag,
        // $depth better to specify = 0 to not trigger php error and will not affect the actual value of depth is it has a value ,
        // $args array contain all the information of items and if it has children or other info, should specify empty array, 
        // $id should be 0 just in case there is no defined id

        //put \t which is tap for every depth level that we have, indent is good for better html readablity
		$indent = ( $depth ) ? str_repeat("\t",$depth) : '';
		
       //pre defined vars before the loop to populate our html markup
       // li_attributes is empty, but we can add here any attribute we want to our li
		$li_attributes = '';
		$class_names = $value = '';
		
        /*retrive info from our $item 
        check if our classes inside our item is empty or defined? if empty then return empty array :
        otherwise return the array with the item classes included inside
        */
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		/* $classes[]: when using [] we merge a new array inside the existing array, so we have array inside the existing array
        without overwriting the existing array (same idea like .= for strings)
        check if $args has children (there is ul inside li), has_children is predefined function from wp, if true we add the class dropdown
        or any class we have depending on which framework we are using
        */
		$classes[] = ($args->walker->has_children) ? 'dropdown' : '';
        /* check if we are currently in parent page or sub menu page. by checking if the item has the class current, or the subitem
        has the class 'current_item_ancestor' (applied automatically by wp) then add the class active, if false return empty*/
		$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
        /* add the class by default comes with wp which is 'menu-item' with the id inside $item array*/
		$classes[] = 'menu-item-' . $item->ID;

        /* if we have multiple submenu and multiple dropdown submenus inside our item add class dropdown-submenu */
		if( $depth && $args->walker->has_children ){
			$classes[] = 'dropdown-submenu';
		}
		
        /* merge all these arrays to class_names 
        join() is php predefined function to merge arrays
        add empty space between classes first ' '
        apply_filters('nav_menu_css_class') will edit and adapt all the classes we specified in the proper way for wp
        array_filter() loops through all the elements that are inside this specific array and applies the filter we specified which is $classes
        and must apply filter to $item and $args */
		$class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ) );

        //print those classes with standard html, not gonna be readable so we use esc_attr()
		$class_names = ' class="' . esc_attr($class_names) . '"';
		
        /* definition of the id that wp needs to apply fort single elements 
        apply the actial item-ID to id*/
		$id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
        /* check if there is actual id, strlen() detects if the value inside has a length. if yes it will include the id, if no nothing */
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
		
        /* merge everything inside the $output 
            first $indent so we have indentation for everytime our item is in actual submenu
            item is li,  and we connect all the values we created.
        */
		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';
		
        /* attributes for our a tags, must check if every attr is not empty so we dont get errors. */
		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr($item->target) . '"' : '';
        // xfn contains the rel statment
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr($item->url) . '"' : '';

		// add specific custom class if the link has children, if args has children then we add all this html from bootstrap
		$attributes .= ( $args->walker->has_children ) ? ' class="nav-link dropdown-toggle" data-toggle="dropdown"' : '';
		
        /* item_output will contain all the elements that we defined.
            the 'before' statment of args is whatever class html wp generats by default

        */
		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        // apply arrow if element has children, only for the first parent, we add the arrow
		$item_output .= ( $depth == 0 && $args->walker->has_children ) ? ' <b class="caret"></b></a>' : '</a>';
		$item_output .= $args->after;
		
        //apply everything to our final output
		$output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		
	}
	
}