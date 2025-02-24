<main class="user-main w1 ac gradient">
  <section class="user-section con" id="login">
    <a href="/" class="logo round abs user-form-logo"><h1>FakeBook</h1></a>
    <h1 class="form-title abs">sign in</h1>
    <form action="/loginCtrl" method="post" class="fc user-input-container">
      <input type="text" name="id" placeholder="Enter Your ID" required autofocus>
      <input type="password" name="pw" placeholder="Enter Your PW" required>
      <!-- <div class="fx"> -->
        <input type="text" name="captcha" placeholder="Enter Captcha" required>
      <!-- </div> -->
      <button type="submit" class="btn abs">sign in</button>
    </form>
  </section>
</main>
</body>
</html>