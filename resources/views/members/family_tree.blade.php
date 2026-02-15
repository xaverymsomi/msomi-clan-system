@extends('layouts.admin')

@section('header')
    {{ __('members.family_tree') }}
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow-lg overflow-hidden relative" style="height: 80vh;">
        <!-- Loading Overlay -->
        <div id="loading" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center z-10 transition-opacity duration-300">
            <div class="flex flex-col items-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600 mb-4"></div>
                <p class="text-gray-600 font-medium">Generating Family Tree...</p>
            </div>
        </div>

        <!-- Tooltip -->
        <div id="tooltip" class="absolute hidden bg-white p-3 rounded shadow-xl border border-gray-100 z-20 pointer-events-none min-w-[200px]">
            <img id="ttp-photo" src="" class="w-full h-32 object-cover rounded mb-2 hidden">
            <h4 id="ttp-name" class="font-bold text-gray-900"></h4>
            <p id="ttp-details" class="text-xs text-gray-500"></p>
        </div>

        <!-- Controls -->
        <div class="absolute top-4 left-4 z-10 flex space-x-2">
            <button onclick="zoomIn()" class="p-2 bg-white rounded shadow-md hover:bg-gray-50 text-gray-700" title="Zoom In">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </button>
            <button onclick="zoomOut()" class="p-2 bg-white rounded shadow-md hover:bg-gray-50 text-gray-700" title="Zoom Out">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
            </button>
            <button onclick="resetZoom()" class="p-2 bg-white rounded shadow-md hover:bg-gray-50 text-gray-700" title="Reset">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            </button>
        </div>

        <svg id="tree-svg" class="w-full h-full cursor-move"></svg>
    </div>

    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script>
        let svg, g, simulation, zoom;
        const width = window.innerWidth;
        const height = window.innerHeight * 0.8;

        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route("members.tree-data") }}')
                .then(response => response.json())
                .then(data => {
                    initTree(data);
                    document.getElementById('loading').style.opacity = '0';
                    setTimeout(() => document.getElementById('loading').classList.add('hidden'), 300);
                });
        });

        function initTree(data) {
            svg = d3.select("#tree-svg")
                .attr("viewBox", [0, 0, width, height]);

            g = svg.append("g");

            zoom = d3.zoom()
                .scaleExtent([0.1, 4])
                .on("zoom", (event) => g.attr("transform", event.transform));

            svg.call(zoom);

            simulation = d3.forceSimulation(data.nodes)
                .force("link", d3.forceLink(data.links).id(d => d.id).distance(100))
                .force("charge", d3.forceManyBody().strength(-300))
                .force("center", d3.forceCenter(width / 2, height / 2))
                .force("collision", d3.forceCollide().radius(40));

            const link = g.append("g")
                .attr("stroke", "#94a3b8")
                .attr("stroke-opacity", 0.6)
                .selectAll("line")
                .data(data.links)
                .join("line")
                .attr("stroke-width", d => d.type === 'father' ? 2 : 1.5)
                .attr("stroke-dasharray", d => d.type === 'mother' ? "4,4" : "0");

            const node = g.append("g")
                .selectAll("g")
                .data(data.nodes)
                .join("g")
                .attr("class", "node")
                .call(drag(simulation))
                .on("mouseover", showTooltip)
                .on("mouseout", hideTooltip)
                .on("click", (event, d) => window.location.href = `/members/${d.id}`);

            // Node Circle
            node.append("circle")
                .attr("r", 25)
                .attr("fill", d => d.gender === 'male' ? '#3b82f6' : '#ec4899')
                .attr("stroke", "#fff")
                .attr("stroke-width", 2)
                .attr("class", "shadow-sm");

            // Initials/Image Mask
            node.append("text")
                .attr("dy", ".31em")
                .attr("text-anchor", "middle")
                .attr("fill", "white")
                .attr("font-size", "10px")
                .attr("font-weight", "bold")
                .attr("pointer-events", "none")
                .text(d => d.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase());

            simulation.on("tick", () => {
                link
                    .attr("x1", d => d.source.x)
                    .attr("y1", d => d.source.y)
                    .attr("x2", d => d.target.x)
                    .attr("y2", d => d.target.y);

                node.attr("transform", d => `translate(${d.x},${d.y})`);
            });
        }

        function drag(simulation) {
            function dragstarted(event) {
                if (!event.active) simulation.alphaTarget(0.3).restart();
                event.subject.fx = event.subject.x;
                event.subject.fy = event.subject.y;
            }
            function dragged(event) {
                event.subject.fx = event.x;
                event.subject.fy = event.y;
            }
            function dragended(event) {
                if (!event.active) simulation.alphaTarget(0);
                event.subject.fx = null;
                event.subject.fy = null;
            }
            return d3.drag()
                .on("start", dragstarted)
                .on("drag", dragged)
                .on("end", dragended);
        }

        function showTooltip(event, d) {
            const tt = document.getElementById('tooltip');
            const img = document.getElementById('ttp-photo');
            const name = document.getElementById('ttp-name');
            const details = document.getElementById('ttp-details');

            if(d.photo) {
                img.src = d.photo;
                img.classList.remove('hidden');
            } else {
                img.classList.add('hidden');
            }

            name.innerText = d.name;
            details.innerText = `${d.region}, ${d.village}`;
            
            tt.classList.remove('hidden');
            
            const mouseX = event.pageX;
            const mouseY = event.pageY;
            
            tt.style.left = (mouseX + 15) + 'px';
            tt.style.top = (mouseY - 15) + 'px';
        }

        function hideTooltip() {
            document.getElementById('tooltip').classList.add('hidden');
        }

        function zoomIn() { svg.transition().call(zoom.scaleBy, 1.3); }
        function zoomOut() { svg.transition().call(zoom.scaleBy, 0.7); }
        function resetZoom() { svg.transition().call(zoom.transform, d3.zoomIdentity); }
    </script>

    <style>
        .node { cursor: pointer; transition: filter 0.2s; }
        .node:hover { filter: brightness(1.1); }
        #tooltip { transition: opacity 0.2s; }
    </style>
@endsection
