
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="modal" id="showModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">

                <div class="modal-header">
                  <h5 class="modal-title">강사 팝업</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4 select-outline">

                              <label>강사 목록</label>
                              <select class="col-md-11 mdb-select md-form md-outline" size="10">
                                <option value="1">홍길동</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                              </select>

                            </div>
                            <div class="col-md-3">
                                <button>추가</button>
                                <button>삭제</button>

                            </div>

                            <div class="col-md-4 select-outline ml-auto">
                                <div class="">
                                    <label>주강사</label>
                                    <select class="col-md-11 mdb-select md-form md-outline">
                                        <option value="1">Option 1</option>
                                    </select>
                                </div>
                                <p>&nbsp;</p>
                                <div class="">
                                    <label>보조강사</label>
                                    <select class="col-md-11 mdb-select md-form md-outline" size="5">
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                      </div>
                    </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-primary">저장</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                </div>
              </div>
            </div>
          </div>

