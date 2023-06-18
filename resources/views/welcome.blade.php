@extends('layouts.mylayout')
@section('content')
<div class="main-body" ng-app="angularTable">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <section class="header-title">
                    <h3 class=" title-h3">
                        1000+ Part Time Jobs in India
                    </h3>
                    <p class="articl-p">
                        Browse 1654 jobs in India
                    </p>
                    <div class="location-of-job show-small-sort">
                        <h6 class="job-found-location">Jobs in India</h6>
                    </div>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 sm-fullwidth" ng-controller="listdata as data">
                <!-- Job -->
                <div ng-if="data.items.length <= 0">
                    <section class="job-box " ng-repeat="i in data.loderItems">
                        <div class="job-info">
                            <div class="title-job-company ">
                                <p class="background-loader hw20x80per "> </p>
                                <span class="desc">
                                    <h4 class="company-name background-loader hw20xfull"></h4>
                                    <p class="post-time show-small"></p>
                                    <div class="more-details">
                                        <ul>
                                            <li><span class="background-loader hw20x100per ">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;</span></li>
                                            <li><span class="small-desc background-loader hw20x100per"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;</span></li>
                                        </ul>
                                    </div>
                            </div>
                            <div class="info-favourite">
                                <div class="time-like">
                                    <p class="post-time hide-small background-loader hw10xfull"></p>
                                </div>
                                <div class="company-logo">
                                    <p class="background-loader hw50xfull"></p>
                                </div>
                            </div>
                        </div>
                        <div class="short-description">
                            <p class="description-p background-loader hw20xfull"></p>
                            <p class="description-p background-loader hw20xfull"></p>
                        </div>
                    </section>
                </div>
                <!-- Job -->
                <section class="job-box " ng-repeat="item in data.items">
                    <div class="job-info">
                        <div class="title-job-company">
                            <h4 class="job"> @{{ item.job_title }}</h4>
                            <span class="desc">
                                <img src="./assets/img/Path 49046.svg" alt="right-mark" srcset=""> @{{ item.job_type_lable }}</span>
                            <h4 class="company-name">@{{ item.company_name }}</h4>
                            <p class="post-time show-small">@{{ item.created_tz }}</p>

                            <div class="more-details">
                                <ul>
                                    <li><img src="./assets/img/Group 11462.svg" alt="time-icon" srcset=""><span class="small-desc">@{{ item.experience }}</span></li>
                                    <li><img src="./assets/img/Coin.svg" alt="dolar-coin" srcset=""><span class="small-desc"> @{{ item.salary }}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="info-favourite">
                            <div class="time-like">
                                <p class="post-time hide-small">@{{ item.created_tz }}</p>
                                <img src="./assets//img/Saved-3.svg" alt="star-icon" class="ml-15">
                            </div>
                            <div class="company-logo">
                                <img src="./assets/img/architecture-1.svg" alt="Fedex-job">
                            </div>
                        </div>
                    </div>
                    <div class="short-description">
                        <p class="description-p">@{{ item.description }}</p>
                    </div>
                </section>
                <!-- Job -->
                <!-- Pagination -->
                <div class="pagination">
                    <ul class="pages">
                        <li class="page-number" ng-repeat="item in data.page_ob">
                            <span ng-if="item.is_enable == 0 && item.is_active !=1" class="nav-page" ng-class="{'active' : item.is_active , 'diasbled' : (item.is_enable ==0)}">@{{ item.lable}}</span>
                            <a ng-if="item.is_enable == 1 || item.is_active ==1" ng-click="goToPage(item.val)" class="nav-page" ng-class="{'active' : item.is_active , 'diasbled' : (item.is_enable ==0)}" href="javascript:void(0)">@{{ item.lable}}</a>
                        </li>
                    </ul>
                </div>
                <div class="load-more">
                    <div class="">
                        <button class="load">Load More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    var app = angular.module('angularTable', []);
    app.controller('listdata', function($scope, $http) {
        var vm = this;
        vm.loderItems = [1, 2, 3, 4, 5, 6];
        vm.items = []; //declare an empty array
        vm.page_ob = []; //declare an empty array

        vm.getData = function(pageno) { // This would fetch the data on page change.
            vm.items = []; // Make empty to show the loaders
            //In practice this should be in a factory.
            $http.get("{{ url('api/v1.0/find-jobs')}}?page=" + pageno).then(function(response) {
                vm.items = response.data.data.data; //ajax request to fetch data into vm.data
                vm.page_ob = response.data.data.page_ob;
                vm.total_count = response.total_count;
            }, function(error) {
                console.log(error);
            });
        };
        $scope.goToPage = function(page) {
            vm.getData(page);
        }
        vm.getData(vm.pageno); // Call the function to fetch initial data on page load.
    });
</script>
@endpush