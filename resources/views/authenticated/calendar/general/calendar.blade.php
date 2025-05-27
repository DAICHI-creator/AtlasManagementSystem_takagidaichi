<x-sidebar>
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelModal">
        予約キャンセル
      </button>
    </div>
  </div>
</div>

<!-- キャンセル確認モーダル -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="cancelForm" method="POST" action="{{ route('reservation.cancel') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cancelModalLabel">予約キャンセルの確認</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          本当に予約をキャンセルしますか？
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
          <button type="submit" class="btn btn-danger">キャンセルする</button>
        </div>
      </div>
    </form>
  </div>
</div>
</x-sidebar>
