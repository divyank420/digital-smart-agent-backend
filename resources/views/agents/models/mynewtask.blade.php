<div class="c-modal c-modal--newmytask" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="c-modal__backdrop js-modal__backdrop"></div>
    <div class="c-modal__dialog" role="document">
      <div class="c-modal__content">



        <div class="modal__body">

          <div class="content">
            <div class="content__head" style="margin-bottom:0;">
              <div class="content__wrap"><input class="content__title title title_md title_input" type="text"
                  placeholder="Estate Planning Marketing">
              </div>
            </div>
            <div class="content__head">
              <div class="content__wrap">
                <div class="meta"><i style="font-size: 20px;margin-right:10px;" class="las la-bullseye"></i>Estate /
                  Living Trust</div>
              </div>
            </div>
            <div class="content__container">
              <div class="content__section">
                <div class="content__body">
                  <div class="content__row">
                    <div class="content__col">
                      <div class="content__box">
                        <div class="content__label fs-14">Assigned to</div>
                        <div class="content__wrap">
                          <div class="d-flex align-items-center">
                            <div class="timelog-drop">
                              <div class="field ">
                                <div class="field__wrap">
                                  <div class="field__inner"><select class="field__select js-select-2-no-search"
                                      data-placeholder="Department">
                                      <option></option>
                                      <option val="1">Department</option>
                                      <option val="2">Marketing</option>
                                      <option val="3">Accounting</option>
                                      <option val="3">Human Resources</option>
                                      <option val="4">Paralegal Team</option>
                                    </select></div>
                                  <div class="field__icon"><i class="las la-angle-down "></i></div>
                                </div>
                              </div>
                            </div>
                            <div class="or-set">
                              <p>OR</p>
                            </div>
                            <div class="timelog-drop">
                              <div class="field ">
                                <div class="field__wrap">
                                  <div class="field__inner"><select id="myval" class="field__select js-select-2-no-search"
                                      data-placeholder="User">
                                      <option></option>
                                      <option val="1">James Goldman</option>
                                      <option val="2">James Goldman</option>
                                      <option val="3">James Goldman</option>
                                      <option val="4">James Goldman</option>
                                    </select></div>
                                  <div class="field__icon"><i class="las la-angle-down "></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="content__box">
                        <div class="content__label fs-14">Type Task</div>
                        <div class="content__wrap">
                          <div class="d-flex align-items-center">
                            <div class="timelog-drop">
                              <div class="field ">
                                <div class="field__wrap">
                                  <div class="field__inner"><select class="field__select js-select-2-no-search"
                                      data-placeholder="Simple Task">
                                      <option></option>
                                      <option val="1">Simple Task</option>
                                      <option val="2">Automated Email</option>
                                    </select></div>
                                  <div class="field__icon"><i class="las la-angle-down "></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>


                      <div class="content__box">
                        <div class="content__label fs-14">Create this task:</div>
                        <div class="content__wrap">
                          <div class="d-flex align-items-center after-comp">
                            <div class="timelog-drop camp-task">
                              <div class="field">
                                <div class="field__wrap">
                                  <div class="field__inner">
                                    <select class="field__select js-select-2-no-search"
                                      data-placeholder="Choose Action" id="colorselector">
                                      <option></option>
                                      <option value="campaign_start">At Campaign Start</option>
                                      <option value="set_time_period">After Set Time Period</option>
                                      <option value="task_completion">After Task Completion</option>
                                    </select></div>
                                  <div class="field__icon"><i class="las la-angle-down "></i></div>
                                </div>
                              </div>
                            </div>
                            <div class="d-flex colors set_time_period" id="set_time_period">
                              <div class="inpt">
                                <input class="int-day" value="12" />
                              </div>
                              <div class="drp-days">
                                <div class="timelog-drop">
                                  <div class="field ">
                                    <div class="field__wrap">
                                      <div class="field__inner"><select class="field__select js-select-2-no-search"
                                          data-placeholder="Day">
                                          <option></option>
                                          <option value="day">Day</option>
                                          <option value="week">Weeks</option>
                                        </select></div>
                                      <div class="field__icon"><i class="las la-angle-down "></i></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="d-flex colors task_completion align-items-center" id="task_completion">
                              <div class="drp-days">
                                <div class="timelog-drop">
                                  <div class="field ">
                                    <div class="field__wrap">
                                      <div class="field__inner"><select class="field__select js-select-2-no-search"
                                          data-placeholder="0 Day">
                                          <option></option>
                                          <option value="0day">0 Day</option>
                                          <option value="1day">1 Day</option>
                                          <option value="1day">2 Day</option>
                                          <option value="1day">3 Day</option>
                                        </select></div>
                                      <div class="field__icon"><i class="las la-angle-down "></i></div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="or-set">
                                <p>After</p>
                              </div>

                              <div class="drp-task">
                                <div class="timelog-drop">
                                  <div class="field ">
                                    <div class="field__wrap">
                                      <div class="field__inner"><select class="field__select js-select-2-no-search"
                                          data-placeholder="Select Task">
                                          <option></option>
                                          <option value="email">Welcome Email</option>
                                          <option value="planningemail">Understanding Estate Planning Email</option>
                                          <option value="servicesemail">2 Day</option>
                                        </select>
                                      </div>
                                      <div class="field__icon"><i class="las la-angle-down "></i></div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="content__section border-btm">
                <div class="content__box">
                  <div class="content__label fs-14">Description</div>
                  <div class="content__body"><textarea class="content__textarea"
                      placeholder="Start typing…"></textarea>
                  </div>
                </div>
              </div>
              <div class="content__section">
                <div class="content__box">
                  <a href="#" class="content__label fs-14"><i class="las la-plus"></i> Add Checklist</a>
                  </div>
                </div>
            </div>
          </div>
        </div>

        <div class="modal__footer">
          <div class="panel__head" style="margin-bottom: 0;">
            <div class="panel__group" >
              <div class="content__box" id="up-file">
                <div class="content__body">
                  <div class="control"><input class="control__file" type="file">
                    <div class="control__icon"><i class="la la-cloud-upload-alt "></i></div>
                    <div class="control__wrap">
                      <div class="control__title">Upload attachment</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel__group">
              <button class="reply__btn btn ml-auto" id="simptask">Create Task</button>
              <button class="reply__btn btn ml-auto d-none" id="editemail">Edit Email</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>