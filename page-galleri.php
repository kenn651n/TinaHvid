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

<template>
    <article class="produkt_article">
        <div class="">
            <img class="produkt_billeder" src="" alt="">
        </div>
    </article>
</template>



<div id="primary" <?php astra_primary_class(); ?>>

    <?php astra_primary_content_top(); ?>

    <?php astra_content_page_loop(); ?>

    <?php astra_primary_content_bottom(); ?>

    <div class="galleri_container">
        <div>
            <div class="filtrerings_knap"><button class="filtrer">Filtre <img class="filter_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/images/filter_icon.svg" alt="filtrer"></button></div>

            <div id="filter_menu">
                <nav id="filtrering" class="sortering"><button data-produkt="alle">Vis alle værker</button></nav>
                <nav>Farver
                    <div id="farver_filtrering" class="sortering"></div>
                </nav>

                <nav>Former
                    <div id="former_filtrering" class="sortering"></div>
                </nav>
                <nav>Størrelse
                    <div id="stoerrelse_filtrering" class="sortering"></div>
                </nav>
            </div>

        </div>

        <div>
            <section class="produkt_container">
            </section>
        </div>

    </div>
</div><!-- #primary -->

<script>
    window.addEventListener("load", sidenVises);

    function sidenVises() {
        console.log("filtrer");
        document.querySelector("#filter_menu").classList.add("hide");
        document.querySelector(".filtrer").addEventListener("click", filtrer);
    }

    function filtrer() {
        document.querySelector("#filter_menu").classList.toggle("hide");
    }

    let produkter;
    let genre;
    let filterprodukt = "alle";
    const dburl = "http://oberes.one/Wordpress/tina_hvid/wp-json/wp/v2/produkt?per_page=100";
    const genreurl = "http://oberes.one/Wordpress/tina_hvid/wp-json/wp/v2/genre?per_page=100"

    async function getJson() {
        console.log("getJson");
        const data = await fetch(dburl);
        const genredata = await fetch(genreurl);
        produkter = await data.json();
        produkter.reverse();
        genre = await genredata.json();
        visProdukter();
        opretKnapper();
    }

    function opretKnapper() {
        genre.forEach(genre => {

            if (genre.tag == "farver") {
                document.querySelector("#farver_filtrering").innerHTML += `<button class="filter" data-produkt="${genre.id}">${genre.name}</button>`
            }
            if (genre.tag == "former") {
                document.querySelector("#former_filtrering").innerHTML += `<button class="filter" data-produkt="${genre.id}">${genre.name}</button>`
            }
            if (genre.tag == "stoerrelse") {
                document.querySelector("#stoerrelse_filtrering").innerHTML += `<button class="filter" data-produkt="${genre.id}">${genre.name}</button>`
            }

        })
        addEventListenersToButtons();
    }

    function addEventListenersToButtons() {
        document.querySelectorAll(".sortering button").forEach(elm => {
            elm.addEventListener("click", filtrering);
        })
    }

    function filtrering() {
        filterprodukt = this.dataset.produkt;
        console.log(filterprodukt);
        visProdukter();
    }

    function visProdukter() {
        let temp = document.querySelector("template");
        let container = document.querySelector(".produkt_container");
        container.innerHTML = "";
        console.log(produkter);
        produkter.forEach(produkt => {
            if (filterprodukt == "alle" || produkt.genre.includes(parseInt(filterprodukt))) {

                let klon = temp.cloneNode(true).content;
                klon.querySelector("img").src = produkt.billede.guid;
                klon.querySelector("article").addEventListener("click", () => {
                    location.href = produkt.link;
                });
                container.appendChild(klon);
            }
        })
    }

    getJson();

</script>


<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>
