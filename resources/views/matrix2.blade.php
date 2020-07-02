@extends('layouts.web')

@section('title', "Références || e-earners")

@section('breadtitle', "Mes Références")

@section('breadli')
<li class="breadcrumb-item active">Références</li>               
@endsection

@section('content')

<style>
    .tree ul {
        padding-top: 20px; position: relative;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .tree li {
        float: left; text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 5px 0 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .tree li::before, .tree li::after{
        content: '';
        position: absolute; top: 0; right: 50%;
        border-top: 1px solid #ccc;
        width: 50%; height: 20px;
    }
    .tree li::after{
        right: auto; left: 50%;
        border-left: 1px solid #ccc;
    }

    .tree li:only-child::after, .tree li:only-child::before {
        display: none;
    }

    .tree li:only-child{ padding-top: 0;}

    .tree li:first-child::before, .tree li:last-child::after{
        border: 0 none;
    }
    .tree li:last-child::before{
        border-right: 1px solid #ccc;
        border-radius: 0 5px 0 0;
        -webkit-border-radius: 0 5px 0 0;
        -moz-border-radius: 0 5px 0 0;
    }
    .tree li:first-child::after{
        border-radius: 5px 0 0 0;
        -webkit-border-radius: 5px 0 0 0;
        -moz-border-radius: 5px 0 0 0;
    }
    .tree ul ul::before{
        content: '';
        position: absolute; top: 0; left: 50%;
        border-left: 1px solid #ccc;
        width: 0; height: 20px;
    }
    .tree li div{
        border: 1px solid #ccc;
        padding: 5px 10px;
        text-decoration: none;
        color: #666;
        font-family: arial, verdana, tahoma;
        font-size: 11px;
        display: inline-block;

        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }
    .tree li div:hover, .tree li div:hover+ul li div {
        background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
    }
    .tree li div:hover+ul li::after, 
    .tree li div:hover+ul li::before, 
    .tree li div:hover+ul::before, 
    .tree li div:hover+ul ul::before{
        border-color:  #94a0b4;
    }

</style>

<!--     <div class="row">
        <div class="tree">
            <ul>
                <li>
                    <div><input type="checkbox"> Main <br/> <button> Test Btn </button></div>
                    <ul>
                        <li>
                            <div><input type="checkbox"> Sub-1</div>
                        </li>
                        <li>
                            <div><input type="checkbox"> Sub-2</div>
                            <ul>
                                <li>
                                    <div><input type="checkbox"> Sub-2-1</div>
                                </li>
                                <li>
                                    <div><input type="checkbox"> Sub-2-2</div>
                                </li>
                            </ul>  
                        </li>
                        <li>
                            <div><input type="checkbox"> Sub-3</div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div> -->

    @if ($downlines->count())
        <?php
            $maximum_depth = $downlines[$downlines->count() - 1]->depth;
            $downlines_sum = DB::table('users')->select(DB::raw('users.*, users_tree.*'))->where(['users_tree.ancestor' => Auth::id()])->join('users_tree', 'users.id', '=', 'users_tree.descendant')->count() - 1;
        ?>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <span>Arbre</span>
                    <span class="pull-right">Downlines - ({{$downlines_sum}})</span>
                </h4>
                <div class="row">
                    <div class="tree">
                        <ul>
                            <li>
                                <div>{{Auth::user()->name}}</div>
                                <?php
                                    function tree($ancestor, $depth, $margin_left){
                                        $downlines = DB::table('users')->select(DB::raw('users.*, users_tree.*'))
                                                        ->where(['users_tree.ancestor' => $ancestor, 'users_tree.depth' => 1])
                                                        // ->where(['users_tree.ancestor' => , 'users_tree.depth' => $depth + 1])
                                                        ->join('users_tree', 'users.id', '=', 'users_tree.descendant')
                                                        ->orderBy('users_tree.depth', 'ASC')
                                                        ->get();
                                        if ($downlines){
                                            $depth = $depth + 1;
                                            $i = 1;
                                            echo "<ul>";
                                            foreach ($downlines as $user){
                                                echo "<li>";
                                                $old_margin_left = $margin_left; // get the previous margin left
                                                $margin_left = $margin_left / 2; // get the margin to which the left item is to be aligned
                                                $margin_right = $margin_left + $old_margin_left; // get the margin to which the right item is to be aligned
                                                echo '<div>'.$user->name.'</div>';
                                                tree($user->id, $depth, $margin_left);
                                                if ($i == $downlines->count()){
                                                    echo "</li>";
                                                }
                                                $i++;
                                            }
                                            echo "</ul>";
                                        }
                                        return 1;
                                    }
                                    $depth = 1; // initialize the depth of the tree
                                    $ancestor = Auth::id(); // set the user as the ancestor
                                    $margin_left = 40; // set the separation
                                    tree($ancestor, $depth, $margin_left);
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @for ($level=1; $level <= $maximum_depth; $level++)
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Niveau de Référence - {{$level}}</h4>
                  
                    <div class="table-responsive">
                        <!-- <table id="one" class="table table-bordered table-striped"> -->
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Parent</th>
                                    <th>level</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $level_downlines = DB::table('users')
                                                            ->select(DB::raw('users.*, users_tree.*'))
                                                            ->where('users_tree.ancestor', '=', Auth::id())
                                                            ->where('users_tree.depth', '=', $level)
                                                            ->join('users_tree', 'users.id', '=', 'users_tree.descendant')
                                                            ->orderBy('users_tree.depth', 'ASC')
                                                            ->get();
                                ?>
                                @foreach ($level_downlines as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{DB::table('users')->where('id', $user->parent_id)->first()->username}}</td>
                                        <td>{{$user->level}}</td>
                                        <td>{{date("d-M-Y", strtotime($user->created_at))}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endfor
    @endif

    <?php
/*        function tree(array $data, &$tree = array(), $level = 0) {
            // init
            if (!isset($tree[$level])) $tree[$level] = array();

            foreach ($data as $key => $value) {
                // if value is an array, push the key and recurse through the array
                if (is_array($value)) {
                    $tree[$level][] = $key;
                    echo "<span style='padding-left: 15px'>".$key."</span>";
                    echo "<br />";
                    tree($value, $tree, $level+1);
                }

                // otherwise, push the value
                else {
                    $tree[$level][] = $value;
                    echo "<span style='padding-left: 5px'>".$value."</span>";
                }
            }
        }
        $binary_tree = array(1 => array(2 => array(4,5),4=>array(5,6)));
        tree($binary_tree, $output);
        // dd($output);
*/    ?>
@endsection