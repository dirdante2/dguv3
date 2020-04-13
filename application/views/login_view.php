<br><br>
      
       <div class="col-md-4 col-md-offset-4">
         <form class="form-signin" action="<?php echo site_url('login/auth');?>" method="post">
           <h2 class="form-signin-heading">Bitte anmelden</h2><br>
           <?php echo $this->session->flashdata('msg');?>
           <label for="username" class="sr-only">Username</label><br>
           <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
           <label for="password" class="sr-only">Password</label><br>
           <input type="password" name="password" class="form-control" placeholder="Password" required>
           <div class="checkbox">
             <label>
               <input type="checkbox" value="remember-me"> anmeldung speichern
             </label>
           </div><br>
           <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
         </form>
       </div>
       
 
    
