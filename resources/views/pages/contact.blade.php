@extends('layouts.app')

@section('content')
  <h2>Contact Me</h2>

  <section class="box post">
    <p></p>
    <p>
        If you have questions, suggestions, or just want to say hello, feel free to drop me a line.</p>
    <ul>
      <li><strong>Email:</strong> <a href="mailto:example@gmail.com">evalds.berzins120@gmail.com</a></li>
      <li><strong>Discord:</strong> b1rcchh</li>
      <li><strong>GitHub:</strong> <a href="https://github.com/EBRZ124" target="_blank">github.com/EBRZ124</a></li>
    </ul>
  </section>

  <section class="box post">
    <header>
      <h3>Send a Message</h3>
    </header>
    <form method="POST" action="{{ route('contact.send') }}">
      @csrf

      <div class="field half">
        <label for="name">Your Name</label>
        <input type="text" name="name" id="name" placeholder="White Cat" required />
      </div>

      <div class="field half">
        <label for="email">Your Email</label>
        <input type="email" name="email" id="email" placeholder="john@example.com" required />
      </div>

      <div class="field">
        <label for="message">Message</label>
        <textarea name="message" id="message" rows="6" placeholder="Write your message here…" required></textarea>
      </div>

      <ul class="actions">
        <li><input type="submit" value="Send Message" class="button" /></li>
      </ul>
    </form>
  </section>
@endsection
