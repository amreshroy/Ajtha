/**
 * Get Started button on dashboard notice.
 *
 * @package Color MagazineX
 */

jQuery(document).ready(function($) {
    var WpAjaxurl = mtAdminObject.ajax_url;
    var _wpnonce = mtAdminObject._wpnonce;
    var buttonStatus = mtAdminObject.buttonStatus;

    /**
     * Popup on click demo import if mysterythemes demo importer plugin is not activated.
     */
    if( buttonStatus === 'disable' ) $( '.mt-demo-import' ).addClass( 'disabled' );

    switch( buttonStatus ) {
        case 'activate' :
            $( '.mt-get-started' ).on( 'click', function() {
                var _this = $( this );
                color_magazinex_do_plugin( 'color_magazinex_activate_plugin', _this );
            });
            $( '.mt-activate-demo-import-plugin' ).on( 'click', function() {
                var _this = $( this );
                color_magazinex_do_plugin( 'color_magazinex_activate_plugin', _this );
            });
            break;
        case 'install' :
            $( '.mt-get-started' ).on( 'click', function() {
                var _this = $( this );
                color_magazinex_do_plugin( 'color_magazinex_install_plugin', _this );
            });
            $( '.mt-install-demo-import-plugin' ).on( 'click', function() {
                var _this = $( this );
                color_magazinex_do_plugin( 'color_magazinex_install_plugin', _this );
            });
            break;
        case 'redirect' :
            $( '.mt-get-started' ).on( 'click', function() {
                var _this = $( this );
                location.href = _this.data( 'redirect' );
            });
            break;
    }
    
    color_magazinex_do_plugin = function ( ajax_action, _this ) {
        $.ajax({
            method : "POST",
            url : WpAjaxurl,
            data : ({
                'action' : ajax_action,
                '_wpnonce' : _wpnonce
            }),
            beforeSend: function() {
                var loadingTxt = _this.data( 'process' );
                _this.addClass( 'updating-message' ).text( loadingTxt );
            },
            success: function( response ) {
                if( response.success ) {
                    var loadedTxt = _this.data( 'done' );
                    _this.removeClass( 'updating-message' ).text( loadedTxt );
                }
                location.href = _this.data( 'redirect' );
            }
        });
    }

    /**
     * plugin install and activate in theme's userful plugin dashboard
     */
    $('.mt-plugin-action').on('click', function(e){
        e.preventDefault();
        var _this = $( this ), btnAction = $(this).data('action'), pluginSlug = $(this).data('slug');
        switch( btnAction ) {
            case 'activate' :
                color_magazinex_do_free_plugin( 'color_magazinex_activate_free_plugin', _this, pluginSlug );
                break;
            case 'install' :
                color_magazinex_do_free_plugin( 'color_magazinex_install_free_plugin', _this, pluginSlug );
                break;
        }
    });

    color_magazinex_do_free_plugin = function ( ajax_action, _this, slug ) {
        $.ajax({
            method : "POST",
            url : WpAjaxurl,
            data : ({
                'action'    : ajax_action,
                '_wpnonce'  : _wpnonce,
                'plugin'    : slug,
            }),
            beforeSend: function() {
                var loadingTxt = _this.data( 'process' );
                _this.addClass( 'updating-message' ).text( loadingTxt );
            },
            success: function( response ) {
                if( response.success ) {
                    var loadedTxt = _this.data( 'done' );
                    _this.removeClass( 'updating-message' ).text( loadedTxt );
                    console.log( response.data.message );
                }
                location.href = _this.data( 'redirect' );
            }
        });
    }


});