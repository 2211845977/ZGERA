@extends('layouts.app')

@section('title', 'نتائج الفصل الدراسي')

@section('content')
<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col text-center">
          <h2>درجات الطالب في جميع الفصول</h2>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- الفصل الأول -->
      <div class="card mb-4">
        <div class="card-header bg-white">
          <h5 class="text-primary fw-bold">الفصل الأول</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead class="table-primary">
                <tr>
                  <th>المادة</th>
                  <th>درجة الأعمال (30)</th>
                  <th>الامتحان النهائي (30)</th>
                  <th>الدرجة النهائية (60)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>جافا</td>
                  <td>18</td>
                  <td>26</td>
                  <td><strong>44</strong></td>
                </tr>
                <tr>
                  <td>البرمجة</td>
                  <td>20</td>
                  <td>28</td>
                  <td><strong>48</strong></td>
                </tr>
                <tr>
                  <td>تطوير تطبيقات الإنترنت</td>
                  <td>16</td>
                  <td>25</td>
                  <td><strong>41</strong></td>
                </tr>
                <tr class="table-secondary fw-bold">
                  <td colspan="3">معدل الفصل الأول</td>
                  <td>44.33</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- الفصل الثاني -->
      <div class="card mb-4">
        <div class="card-header bg-white">
          <h5 class="text-primary fw-bold">الفصل الثاني</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead class="table-primary">
                <tr>
                  <th>المادة</th>
                  <th>درجة الأعمال (30)</th>
                  <th>الامتحان النهائي (30)</th>
                  <th>الدرجة النهائية (60)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>قواعد البيانات</td>
                  <td>17</td>
                  <td>27</td>
                  <td><strong>44</strong></td>
                </tr>
                <tr>
                  <td>جودة البرمجيات</td>
                  <td>19</td>
                  <td>29</td>
                  <td><strong>48</strong></td>
                </tr>
                <tr>
                  <td>نظم التشغيل</td>
                  <td>16</td>
                  <td>26</td>
                  <td><strong>42</strong></td>
                </tr>
                <tr class="table-secondary fw-bold">
                  <td colspan="3">معدل الفصل الثاني</td>
                  <td>44.67</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- المعدل العام -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-dark">
          <i class="fas fa-chart-bar text-success"></i>
          المعدل العام: <span class="text-primary">44.50</span>
        </h5>
        <button class="btn btn-outline-primary" onclick="window.print()">طباعة</button>
      </div>

    </div>
  </section>
</div>
@endsection