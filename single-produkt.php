<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

<?php get_sidebar(); ?>

<?php endif ?>

<div id="primary" <?php astra_primary_class(); ?>>

    <?php astra_primary_content_top(); ?>

    <?php astra_content_page_loop(); ?>

    <?php astra_primary_content_bottom(); ?>


    <article class="single_produkt">
        <div>
            <img class="produkt_billede" src="" alt="">
        </div>
        <div class="produkt_info">
            <h2 class="produkt_navn"></h2>
            <p class="beskrivelse"></p>
            <p class="detaljer"></p>
            <p class="kontakt"></p>
            <a href="http://oberes.one/Wordpress/tina_hvid/kontakt/" class="kontaktknap"><button style="border: solid 1px">Kontakt</button></a>
            <br><br>
            <p class="kbhkunst"></p>
            <a href="https://www.kbhkunst.dk/vare-kategori/artist/tine-hvid/" target="_blank" rel="noopener noreferrer"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Kbh_kunst.svg" alt="KBHkunst" style="width: 140px;"></a>
        </div>
    </article>


</div><!-- #primary -->

<script>
    let produkt;
    const dburl = "http://oberes.one/Wordpress/tina_hvid/wp-json/wp/v2/produkt/" + <?php echo get_the_ID()?>;
    async function getJson() {
        const data = await fetch(dburl);
        produkt = await data.json();
        visprodukt();
    }

    function visprodukt() {
        document.querySelector(".produkt_navn").innerHTML = produkt.title.rendered;
        document.querySelector(".produkt_billede").src = produkt.billede.guid;
        document.querySelector(".beskrivelse").innerHTML = produkt.beskrivelse;
        document.querySelector(".detaljer").innerHTML = produkt.detaljer;
        document.querySelector(".kontakt").innerHTML = produkt.kontakt;
        document.querySelector(".kbhkunst").innerHTML = produkt.kbhkunst;
    }

    getJson();

</script>


<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>
