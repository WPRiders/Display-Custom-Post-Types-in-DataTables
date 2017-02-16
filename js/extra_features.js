(function ($) {
    wpr_initiate_table();

    function wpr_initiate_table() {
        var oTable;

        $.ajax({
            type: 'POST',
            async: true,
            url: wpr_plugin_info.wpr_ajax_url,
            data: {action: 'wpr_get_posts_list'},
            success: function (response) {
                oTable = $('#wprlistingTable').DataTable({
                    "aaData": response,
                    "processing": true,
                    "bFilter": true,
                    "bInfo": false,
                    "bUseColVis": true,
                    'iDisplayLength': 100,
                    "columns": [{
                        "data": "ID"
                    }, {
                        "data": "Title"
                    }, {
                        "data": "Published date"
                    }, {
                        "data": "Status"
                    }]
                });
            }
        });
    }
})
(jQuery);