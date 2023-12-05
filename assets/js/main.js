jQuery.noConflict();
jQuery(document).ready(function($) {
    // Função para carregar o conteúdo via AJAX
    function loadPageContent(action, activeLink) {
        var data = {
            'action': action
        };

        $.post(ajax_object.ajax_url, data, function(response) {
            $('#content').html(response);
        });
    }

    // Função para obter o valor do parâmetro da URL
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Manipula os cliques nos links
    $('[title="load-contact-page"]').click(function(event) {
        event.preventDefault();
        var activeLink = 'contact';
        localStorage.setItem('activeLink', activeLink);
        loadPageContent('load_contact_page_content', activeLink);

        // Atualiza a URL no histórico de navegação
        var newUrl = window.location.origin + window.location.pathname + '?activeLink=' + activeLink;
        window.history.pushState({ path: newUrl }, '', newUrl);
    });

    $('[title="servic"]').click(function(event) {
        event.preventDefault();
        var activeLink = 'servic';
        localStorage.setItem('activeLink', activeLink);
        loadPageContent('load_servic_page_content', activeLink);

        // Atualiza a URL no histórico de navegação
        var newUrl = window.location.origin + window.location.pathname + '?activeLink=' + activeLink;
        window.history.pushState({ path: newUrl }, '', newUrl);
    });

    // Verifica a URL ao carregar a página
    var initialActiveLink = getUrlParameter('activeLink');
    if (initialActiveLink) {
        localStorage.setItem('activeLink', initialActiveLink);

        // Carrega o conteúdo com base no parâmetro da URL
        if (initialActiveLink === 'contact') {
            loadPageContent('load_contact_page_content', initialActiveLink);
        } else if (initialActiveLink === 'servic') {
            loadPageContent('load_servic_page_content', initialActiveLink);
        }
    }

    // Manipula os eventos de popstate para lidar com a navegação do navegador
    window.onpopstate = function(event) {
        var activeLink = localStorage.getItem('activeLink');
        if (activeLink === 'contact') {
            // Carrega o conteúdo da página de contato
            loadPageContent('load_contact_page_content', activeLink);
        } else if (activeLink === 'servic') {
            // Carrega o conteúdo da página de serviço
            loadPageContent('load_servic_page_content', activeLink);
        }
    };
});
