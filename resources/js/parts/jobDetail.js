$(function() {
    //teldialのモーダル
    var wn;
    $('#jobone .telDialog').click(function() {
        wn = '#jobone .' + $(this).data('modaltarget');
        var mW = $(wn).find('.jobModalBody').innerWidth() / 2;
        $(wn).find('.jobModalBody').css({'margin-left': -mW});
        $(wn).fadeIn(0);
        return false;
    });
    //jobModalのクローズ処理
    $('#jobone .jobModalClose, #jobone .jobModalBK,#jobone .jobModalClear').click(function() {
        if(wn){
            $(wn).fadeOut(0);
        }
    });
    //flickSimpleによるフリックとスライダー
    if(document.getElementById("JobImg") != null){
        var ind = $('#ImgCount');
        $('#JobImg').flickSimple({
            snap: 'first',
            paginate: 'x',
            onResize: function() {
                var min_h = 200;
                $('#JobImg ul li img').css('max-height', '200px');
                $('#JobImg ul li img').each(function() {
                    var current_h = $(this).height();
                    if(min_h > current_h && current_h != 0){
                        min_h = current_h;
                    }
                });
                var licsnt = $('#JobImg ul li').length;
                this.pageLength = licsnt;
                this.pageWidth = $(window).width();
                if(isNaN(this.page) == true){
                    this.page = 1;
                }
                $('#JobImg ul').css('width', (licsnt * 100) + '%');
                $('#JobImg ul li').css('width', (100 / licsnt) + '%');
                $('#JobImg ul li img').css('max-width', this.pageWidth + 'px');
                $('#JobImg ul li img').css('max-height', min_h + 'px');
            },
            onChange: function() {
                var min_h = 200;
                $('#JobImg ul li img').css('max-height', '200px');
                $('#JobImg ul li img').each(function() {
                    var current_h = $(this).height();
                    if(min_h > current_h && current_h != 0){
                        min_h = current_h;
                    }
                });
                var licsnt = $('#JobImg ul li').length;
                this.pageLength = licsnt;
                this.pageWidth = $(window).width();
                if(isNaN(this.page) == true){
                    this.page = 1;
                }
                if(this.page > licsnt){
                    this.page = licsnt;
                }
                $('#JobImg ul').css('width', (licsnt * 100) + '%');
                $('#JobImg ul li').css('width', (100 / licsnt) + '%');
                $('#JobImg ul li img').css('max-width', this.pageWidth + 'px');
                $('#JobImg ul li img').css('max-height', min_h + 'px');
                ind.html(this.page + '/' + this.pageLength);
            }
        });
        var fs = $('#JobImg').flickSimple();
        fs.onChange();
        $('#ImgPrevBtn').click(function() {
            fs.prevPage(1);
            return false;
        });
        $('#ImgNextBtn').click(function() {
            fs.nextPage(1);
            return false;
        });
    }

    $('.isConcier').click(function() {
        $(this).next('.concierDetailModal').show();
    });

    $('.concierDetailModal .close').click(function() {
        $(this).parent('.concierDetailModal').hide();
    });

});





