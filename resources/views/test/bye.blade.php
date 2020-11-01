@extends ('test.layout')


<form>
    <div class="form-group">
      <label for="exampleInputEmail1">이메일 주소</label>
      <input type="email" class="form-control" id="exampleInputEmail1" placeholder="이메일을 입력하세요">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">암호</label>
      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="암호">
    </div>
    <div class="form-group">
      <label for="exampleInputFile">파일 업로드</label>
      <input type="file" id="exampleInputFile">
      <p class="help-block">여기에 블록레벨 도움말 예제</p>
    </div>
    <div class="checkbox">
      <label>
        <input type="checkbox"> 입력을 기억합니다
      </label>
    </div>
    <button type="submit" class="btn btn-default">제출</button>
  </form>
  <form class="form-horizontal">
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
          <label>
            <input type="checkbox"> Remember me
          </label>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Sign in</button>
      </div>
    </div>
  </form>
