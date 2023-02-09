<x-base-layout title="Log Viewer">
    @once
        @push('css')
            <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
            <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
            <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
        @endpush
        @push('js')
            <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
            <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.js') }}"></script>
            <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
            <script>
                $(document).ready(function() {
                    $('#logviewer-table').DataTable();
                });
            </script>
        @endpush
    @endonce
    <x-card>
        <x-slot name="body">
            @if ($logs === null)
                <p>Log file exceeds configured limit ({{ config('logviewer.max_file_size') / 1024 / 1024 }} MB)!</p>
            @endif
            <div class="p-3 table-responsive">
                <table id="logviewer-table" class="table table-bordered table-sm text-sm" data-ordering-index="{{ $standardFormat ? 2 : 0 }}">
                    <thead>
                        <tr>
                            @if ($standardFormat)
                                <th style="width: 8ch">Level</th>
                                <th>Context</th>
                                <th style="width: 15ch">Date</th>
                            @else
                                <th>Line number</th>
                            @endif
                            <th>Content</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $key => $log)
                            <tr data-display="stack{{ $key }}">
                                @if ($standardFormat)
                                    <td class="nowrap text-{{ $log['level_class'] }}">
                                        <i class="fas fa-{{ $log['level_img'] }}"></i>
                                        <span class="ml-1">{{ $log['level'] }}</span>
                                    </td>
                                    <td class="text">{{ $log['context'] }}</td>
                                @endif
                                <td class="date">{{ $log['date'] }}</td>
                                <td class="text">
                                    @if ($log['stack'])
                                        <button type="button" class="float-right expand btn btn-outline-dark btn-sm mb-2 ml-2" data-display="stack{{ $key }}">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    @endif
                                    {{ $log['text'] }}
                                    @if (isset($log['in_file']))
                                        <br />
                                        {{ $log['in_file'] }}
                                    @endif
                                    @if ($log['stack'])
                                        <div class="stack" id="stack{{ $key }}" style="display: none; white-space: pre-wrap;">
                                            {{ trim($log['stack']) }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-slot>
        <x-slot name="footer">
            @if ($current_file)
                <a href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                    <i class="fas fa-download"></i>
                    <span class="ml-1">Download</span>
                </a>

                <span class="px-2">&bull;</span>

                <a id="clean-log" href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                    <i class="fas fa-sync"></i>
                    <span class="ml-1">Clean</span>
                </a>

                <span class="px-2">&bull;</span>

                <a id="delete-log" href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                    <i class="far fa-trash-alt"></i>
                    <span class="ml-1">Delete</span>
                </a>

                @if (count($files) > 1)
                    <span class="px-2">&bull;</span>

                    <a id="delete-all-log" href="?delall=true{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                        <i class="fas fa-trash-alt"></i>
                        <span class="ml-1">Delete All</span>
                    </a>
                @endif
            @endif
        </x-slot>
    </x-card>
</x-base-layout>

{{-- @foreach ($folders as $folder)
    <div class="list-group-item">
        @php(\Rap2hpoutre\LaravelLogViewer\LaravelLogViewer::DirectoryTreeStructure($storage_path, $structure))
    </div>
@endforeach
@foreach ($files as $file)
    <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}" @class(['list-group-item', 'llv-active' => $current_file == $file])>
        {{ $file }}
    </a>
@endforeach --}}
