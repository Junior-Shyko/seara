<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ url('/') }}" class="site_title"> <span>Seara Contabilidade</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                @if(empty(Auth::user()->users_avatar))
                    <img src="{{ url('img/default-user-avatar.png') }}" alt="Avatar de {{ Auth::user()->name }}" class="img-circle profile_img">
                @else
                    <img src="{{ url('img/default-user-avatar.png') }}" alt="Avatar de {{ Auth::user()->name }}" class="img-circle profile_img">
                @endif
            </div>
            <div class="profile_info">
                <span>Bem Vindo,</span>
                <h2>{{ Auth::user()->name }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
          <div class="menu_section">
            <!-- <h3><br></h3> -->
            <ul class="nav side-menu">
              <li>
                <a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a>
              </li>
              @if(Auth::user()->profile == 'admin' || Auth::user()->profile == 'owner')
              <li>
                <a href="{{url('users')}}"><i class="fa fa-users"></i> Usuários</a>
              </li>
              @endif
              @if(Auth::user()->profile == 'owner')
                <li>
                  <a href="{{url('clientes')}}"><i class="fa fa-building"></i> Clientes</a>
                </li>
                <li>
                  <a>
                    <i class="fa fa-pencil-square" aria-hidden="true"></i> Cadastro <span class="fa fa-chevron-down"></span>
                  </a>
                  <ul class="nav child_menu">
                    <li><a href="{{url('cadastro')}}">Igreja</a></li>
                    <li><a href="#">Usuário</a></li>
                    <li><a href="#">Histórico</a></li>
                  </ul>
                </li>
              @endif
              <li><a><i class="fa fa-list-ul" aria-hidden="true"></i> Recibo <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li><a href="{{ url('recibo-comum') }}">Comum</a></li>
                  <li><a href="{{url('recibo-empresa')}}">Empresa</a></li>
                  <li><a href="#">R.P.A</a></li>
                </ul>
              </li>

              <li><a href="{{url('caixa')}}"><i class="fa fa-calculator" aria-hidden="true"></i> Caixa <span class="fa fa-chevron-down"></span></a>
                
              </li>

              <li><a><i class="fa fa-list-alt" aria-hidden="true"></i> Relatórios <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li><a href="#">Caixa</a></li>
                  <li><a href="#">Usuário</a></li>
                  <li><a href="#">Igreja</a></li>
                  <li><a>Contrato<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li class="sub_menu"><a href="level2.html">Locação</a>
                      </li>
                      <li><a href="#level2_1">Serviço Voluntário</a>
                      </li>
                      <li><a href="#level2_2">Level Two</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>


            </ul>
          </div>


        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ url('/logout') }}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
