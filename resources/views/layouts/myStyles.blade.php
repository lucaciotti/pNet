{{-- layouts --}}
<style type="text/css">
    .card-header{ padding-top: 8px; padding-bottom: 8px; }
    .card-title{ font-weight: 800; }
    .modal-header{ padding-top: 8px; padding-bottom: 8px }
    .modal-title{ font-weight: 800; }
</style>

{{-- DataTables --}}
<style>
    .dtTbls_light span.date {
        display: none;
    }

    .dtTbls_full span.date {
        display: none;
    }

    .dtTbls_full_Tot span.date {
        display: none;
    }

    .dtTbls_total span.date {
        display: none;
    }
    
</style>

{{-- Thumbnails --}}
<style type="text/css">
    .thumbnail {
        position: relative;
        z-index: 0;
    }

    .thumbnail:hover {
        background-color: transparent;
        z-index: 50;
    }

    .thumbnail span {
        /*CSS for enlarged image*/
        position: absolute;
        background-color: white;
        padding: 5px;
        left: -1000px;
        border: 1px solid gray;
        visibility: hidden;
        display: none;
        color: black;
        text-decoration: none;
    }

    .thumbnail span img {
        /*CSS for enlarged image*/
        border-width: 0;
        padding: 2px;
    }

    .thumbnail:hover span {
        /*CSS for enlarged image on hover*/
        visibility: visible;
        display: block;
        bottom: 0;
        left: 60px;
        /*position where enlarged image should offset horizontally */

    }
</style>

{{-- LiveWire --}}
<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<style>
    #btnCartFooter {
        background-color: #0d91d7;
        color: white;
    }

    #btnCartFooter:hover {
        background-color: #14628c;
    }
</style>
<style>
    .myListGroup {
        max-height: 400px;
        margin-bottom: 10px;
        overflow-y: scroll;
        -webkit-overflow-scrolling: touch;
    }

    .mySearchResults {
        position: absolute;
        width: 500px;
        overflow-y: auto;
        /* background: white; */
        /* border-bottom-left-radius: 10px; */
        /* border-bottom-right-radius: 10px; */
        /* max-height: 200px; */
        /* border: 1px solid gray; */
        /*This is relative to the navbar now*/
        /* left: 0;
        right: 0;
        top: 40px; */
    }

    @media screen and (max-width: 500px) {
        .mySearchResults {
            width: auto;
        }
    }

    .mySearchResults a:link,
    a:visited,
    a:hover,
    a:active {
        color: #000;
    }

    .mySearchResults a:hover,
    a:active {
        background-color: lightblue;
    }

    .mySearchHighlight {
        background-color: lightblue;
    }
</style>