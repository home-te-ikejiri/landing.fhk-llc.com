$(function () {
    var deleteId = null;

    // 削除ボタンクリック → 確認ポップアップ表示
    $(document).on('click', '.btn-delete', function () {
        deleteId = $(this).data('id');
        if (!deleteId) {
            $('.unselected-popup').show();
            return;
        }
        $('.delete-popup').show();
    });

    // キャンセル・ポップアップ外クリックで閉じる
    $(document).on('click', '.cancel', function () {
        $('.delete-popup, .unselected-popup').hide();
        deleteId = null;
    });
    $(document).on('click', '.popup', function (e) {
        if ($(e.target).hasClass('popup')) {
            $(this).hide();
            deleteId = null;
        }
    });

    // 削除確定
    $(document).on('click', '.btn-confirm-delete', function () {
        if (!deleteId) return;

        var target    = $('#target').val();
        var csrfToken = $('input[name="csrf-token"]').attr('content');

        $.ajax({
            url:  '/admin/' + target + '/' + deleteId,
            type: 'POST',
            data: {
                '_method': 'DELETE',
                '_token':  csrfToken
            },
            success: function () {
                $('.delete-popup').hide();
                location.reload();
            },
            error: function () {
                $('.delete-popup').hide();
                alert('削除に失敗しました。');
            }
        });
    });
});
