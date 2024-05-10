<?php if(session()->getFlashData('errors') || session()->getFlashData('error') || session()->getFlashData('success')) : ?>
    <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 10000; right: 0; bottom: 0;">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
        <div class="toast-header">
        <?php if(session()->getFlashData('errors') || session()->getFlashData('error')) : ?>
            <strong class="mr-auto text-danger">Error</strong>
        <?php else : ?>
            <strong class="mr-auto text-success">Sukses</strong>
        <?php endif; ?>
        <small>sekarang</small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="toast-body">
            <?php if(session()->getFlashData('errors')) : ?>
                <?php foreach(session()->getFlashdata('errors')->getErrors() as $error) : ?>
                    <p class="text-danger"><?= $error ?></p>
                <?php endforeach; ?>
            <?php elseif(session()->getFlashData('error')) : ?>
                <p class="text-danger"><?= session()->getFlashData('error') ?></p>
            <?php else : ?>
                <p class="text-success"><?= session()->getFlashdata('success') ?></p>
            <?php endif; ?>
        </div>
    </div>
    </div>

    <script>
        $('#liveToast').toast('show')
    </script>

<?php endif; ?>