<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting App</title>
</head>
<body>

<h1>Candidates</h1>

<form id="candidateForm">
    <label for="candidateName">Candidate Name:</label>
    <input type="text" id="candidateName" name="candidateName" required><br><br>
    <button type="submit">Add Candidate</button>
</form>

<h2>Candidate List</h2>
<ul id="candidateList"></ul>

<h1>Vote</h1>

<form id="voteForm">
    <label for="candidateSelect">Select Candidate:</label>
    <select id="candidateSelect" name="candidateSelect" required></select><br><br>
    <button type="submit">Vote</button>
</form>

<h2>Vote Results</h2>
<p id="voteResults"></p>

<script>
    // Add candidates to local storage
    var defaultCandidates = [
        { name: "Candidate 1", votes: 0 },
        { name: "Candidate 2", votes: 0 },
        { name: "Candidate 3", votes: 0 }
    ];

    if (!localStorage.getItem("candidates")) {
        localStorage.setItem("candidates", JSON.stringify(defaultCandidates));
    }

    // Refresh candidate list
    function refreshCandidateList() {
        var candidateList = document.getElementById("candidateList");
        candidateList.innerHTML = "";

        var candidates = JSON.parse(localStorage.getItem("candidates")) || [];

        candidates.forEach(function(candidate) {
            var listItem = document.createElement("li");
            listItem.textContent = candidate.name + " - Votes: " + candidate.votes;
            candidateList.appendChild(listItem);
        });

        // Update vote form select options
        var voteSelect = document.getElementById("candidateSelect");
        voteSelect.innerHTML = "";

        candidates.forEach(function(candidate) {
            var option = document.createElement("option");
            option.value = candidate.name;
            option.textContent = candidate.name;
            voteSelect.appendChild(option);
        });
    }

    // Initialize candidate list
    refreshCandidateList();

    // Handle form submission to add new candidate
    document.getElementById("candidateForm").addEventListener("submit", function(event) {
        event.preventDefault();

        var candidateName = document.getElementById("candidateName").value;
        var candidates = JSON.parse(localStorage.getItem("candidates")) || [];
        candidates.push({ name: candidateName, votes: 0 });
        localStorage.setItem("candidates", JSON.stringify(candidates));

        document.getElementById("candidateName").value = "";
        refreshCandidateList();
    });

    // Handle form submission to vote
    document.getElementById("voteForm").addEventListener("submit", function(event) {
        event.preventDefault();

        var selectedCandidate = document.getElementById("candidateSelect").value;
        var candidates = JSON.parse(localStorage.getItem("candidates")) || [];

        candidates.forEach(function(candidate) {
            if (candidate.name === selectedCandidate) {
                candidate.votes++;
            }
        });

        localStorage.setItem("candidates", JSON.stringify(candidates));
        refreshCandidateList();
        displayVoteResults();
    });

    // Display vote results
    function displayVoteResults() {
        var candidates = JSON.parse(localStorage.getItem("candidates")) || [];

        // Find the candidate with the most votes
        var winner = candidates.reduce(function(prev, current) {
            return (prev.votes > current.votes) ? prev : current;
        });

        document.getElementById("voteResults").textContent = "Winner: " + winner.name + " with " + winner.votes + " votes.";
    }

    // Initial display of vote results
    displayVoteResults();
</script>








</body>
</html>
