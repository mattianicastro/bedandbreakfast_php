<div class="navbar bg-base-100">
    <div class="navbar-start">
      <div class="dropdown">
        <label tabindex="0" class="btn btn-ghost lg:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
        </label>
        <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
        <li><a href="/">Home</a></li>
        <li><a>Le camere</a></li>
        <li><a>Dove trovarci</a></li>
        </ul>
      </div>
      <a class="md:visible invisible btn btn-ghost normal-case text-xl" href="/index.php">La Nuova Vela</a>
      <a class="md:invisible visible btn btn-ghost normal-case text-xl" href="/index.php"></a>
    </div>
    <div class="navbar-center hidden lg:flex">
      <ul class="menu menu-horizontal px-1">
        <li><a>Le camere</a></li>
        <li><a>Dove trovarci</a></li>
      </ul>
    </div>  
    <div class="navbar-end gap-x-2">
        <a class="btn btn-ghost" href="/private-area/login.php">Area riservata</a>
        <?php
          if(isset($_SESSION['username'])):
        ?>
        <a class="btn btn-ghost" href="/private-area/logout.php">Logout</a>
        <?php
          endif;
        ?>
    </div>
  </div>