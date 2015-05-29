=== Anywhere List Shortcode ===
Contributors: marushu
Tags: post, post type
Requires at least: 3.9.1
Tested up to: 4.2.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
List the article :)

[This plugin published on GitHub.](https://github.com/marushu/anywhere-list-shortcode)

= Fetures =
- WordPress post retrieve and list.
- Purpose to be output by the number specified latest posts mainly is suitable.
- 【NEW 0.2】Added filter( anywhter_before_list_tag, anywhter_list_content, anywhter_after_list_tag ).

You can simply put a "[list]" short code, to list the title of the latest article (link with) and the front page of your blog, sidebar, footer. Set category and custom post type, taxonomy also other it is also possible.

= Parameters =
Main parameters, [refer to the get_posts of Codex](http://codex.wordpress.org/Template_Tags/get_posts).  

- post_type: WordPress post type. Default is post.  
- cat_name: Category slug.  
- num: Number: The number of posts you want to output.  
- class: Unorderd list's class name. maybe easy controllable :)  
- orderby: Post's order.  
- order: Ascending Descending.  
- length: If you want to adjust the length of post title  
- end_of_title: Specify a string to be appended to the end of the article. This must be required for 'length'.  
- taxonomy: If you want to output by specifying a custom taxonomy.  
- term: Required for 'taxonomy'.  
- more: read more link text.
- post_format: post format
- no_filter(boolean): If you are creating a filter hook , you are able to set not affected. :)

= Example =
- [list] most simple.  
- [list post_type=post cat_name=news num=5 class=newslist] at visual editor.  
- `<?php echo do_shortcode( '[list]' ); ?>` at template.  

= Other =
It can also be used in widget :)

== Installation ==
- A plug-in installation screen is displayed on the WordPress admin panel.  
- It installs it in `wp-content/plugins`.  
- The plug-in is made effective.  

== Changelog ==
= 0.2 =
- add filter
- no_filter option

= 0.1 =
- First release :)  

== Contact ==
Twitter: @marushu
email: shuhei.nishimura[at]gmail.com
