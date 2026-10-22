<?php
$YOUTUBE_VIDEO_ID = "dQw4w9WgXcQ"; // Video 1 placeholder (replace later)

function resourceBlock($topicTitle, $extraImageUrl, $youtubeId){
    return '
<div class="resource-block">
    <div class="resource-head">
        <h3 class="resource-title">Partner Resources for: '.htmlspecialchars($topicTitle).'</h3>
        <p class="resource-sub">
            Below is a curated set of vendor, safety, and technical references to support planning, purchasing, and best-practice execution.
            Links are embedded for SEO and user utility.
        </p>
    </div>

    <div class="resource-grid">
        <div class="resource-card">
            <div class="resource-card-title">Recommended Materials & Where to Buy</div>
            <p class="resource-card-text">
                For homeowner-friendly electrical supplies, replacement parts, surge protection, GFCI/AFCI devices, outlets, switches,
                wire management, and basic tools, start with retail suppliers that have broad inventory and consistent specs:
                <a href="https://www.homedepot.com/" target="_blank" rel="noopener noreferrer"><strong>Home Depot</strong></a>,
                <a href="https://www.lowes.com/" target="_blank" rel="noopener noreferrer"><strong>Lowe&#39;s</strong></a>, and
                <a href="https://www.acehardware.com/" target="_blank" rel="noopener noreferrer"><strong>Ace Hardware</strong></a>.
                For contractor-grade procurement and jobsite-consumable continuity, many trades also reference
                <a href="https://www.grainger.com/" target="_blank" rel="noopener noreferrer"><strong>Grainger</strong></a>
                for industrial MRO supply and
                <a href="https://www.whitecap.com/" target="_blank" rel="noopener noreferrer"><strong>White Cap</strong></a>
                for construction jobsite essentials. For lumber, sheathing, and rough framing procurement (when a broader scope is required),
                procurement channels often include
                <a href="https://www.buildersfirstsource.com/" target="_blank" rel="noopener noreferrer"><strong>Builders FirstSource</strong></a>.
            </p>

            <p class="resource-card-text">
                When selecting devices (especially in kitchens, bathrooms, garages, outdoor areas, and bedrooms), match the product category
                to the space use-case. Many homeowners use manufacturer specs and retailer comparison filters to validate compatibility,
                then cross-check installation constraints before purchase. If you need quick access to relevant product categories, explore:
                <a href="https://www.homedepot.com/b/Electrical/N-5yc1vZarcd" target="_blank" rel="noopener noreferrer"><strong>Home Depot Electrical</strong></a>
                and
                <a href="https://www.lowes.com/c/Electrical" target="_blank" rel="noopener noreferrer"><strong>Lowe&#39;s Electrical</strong></a>.
            </p>
        </div>

        <div class="resource-card">
            <div class="resource-card-title">Inspection, Code & Safety References</div>
            <p class="resource-card-text">
                Electrical work in Florida should be planned with inspection-readiness and safety as primary success criteria.
                For jurisdiction workflows (permits, inspections, checklists, and general construction guidance), reference:
                <a href="https://www.tampa.gov/construction-services" target="_blank" rel="noopener noreferrer"><strong>City of Tampa Construction Services</strong></a>
                and
                <a href="https://www.hillsboroughcounty.org/en/businesses/permits-and-records" target="_blank" rel="noopener noreferrer"><strong>Hillsborough County Permits &amp; Records</strong></a>.
                For licensing verification and contractor oversight resources, reference the
                <a href="https://www.myfloridalicense.com/" target="_blank" rel="noopener noreferrer"><strong>Florida DBPR</strong></a>.
            </p>

            <p class="resource-card-text">
                For general safety guidance in construction environments (especially where energized systems are possible),
                many professionals reference
                <a href="https://www.osha.gov/construction" target="_blank" rel="noopener noreferrer"><strong>OSHA Construction</strong></a>.
                For consumer-facing electrical safety education and risk-reduction best practices, consider referencing
                <a href="https://www.esfi.org/" target="_blank" rel="noopener noreferrer"><strong>ESFI Electrical Safety Foundation</strong></a>.
                For standards and code library context (as a publishing reference portal), many users consult
                <a href="https://codes.iccsafe.org/" target="_blank" rel="noopener noreferrer"><strong>ICC Code Library</strong></a>
                (always confirm the adopted edition and local amendments for your jurisdiction).
            </p>
        </div>
    </div>

    <div class="resource-media">
        <div class="resource-media-left">
            <div class="resource-card-title">Image Reference</div>
            <img class="resource-img" src="'.htmlspecialchars($extraImageUrl).'" alt="Reference image for '.htmlspecialchars($topicTitle).'">
            <p class="resource-caption">
                Visual reference helps align expectations for installation quality, safe clearances, and typical component layouts.
                This is an illustrative image intended for educational use.
            </p>
        </div>

        <div class="resource-media-right">
            <div class="resource-card-title">Video 1 (YouTube Placeholder)</div>
            <div class="video-wrap">
                <iframe
                    src="https://www.youtube.com/embed/'.htmlspecialchars($youtubeId).'"
                    title="Video 1"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen>
                </iframe>
            </div>
            <p class="resource-caption">
                Replace the YouTube ID in <strong>$YOUTUBE_VIDEO_ID</strong> to swap the video later.
                If you prefer a link-based video reference instead of an embed, you can also point users to
                <a href="https://www.youtube.com/" target="_blank" rel="noopener noreferrer"><strong>YouTube</strong></a>
                or to vendor training resources and product videos on retailer pages.
            </p>
        </div>
    </div>

    <div class="resource-footer">
        <p class="resource-footer-text">
            Additional high-authority reference hubs commonly used for homeowner education include:
            <a href="https://www.thisoldhouse.com/" target="_blank" rel="noopener noreferrer"><strong>This Old House</strong></a>
            for renovation education and
            <a href="https://www.familyhandyman.com/" target="_blank" rel="noopener noreferrer"><strong>Family Handyman</strong></a>
            for DIY-oriented maintenance topics. For product-specific installation instructions, always prioritize manufacturer documentation.
        </p>
    </div>
</div>';
}

/**
 * One-page expansion content per blog (kept in PHP for maintainability).
 * Each block includes embedded backlinks for SEO + user value.
 */
$expanded = [
    1 => '
<div class="topic-block">
  <h3>Deep Dive: Common Electrical Problems Homeowners Experience</h3>
  <p>
    Electrical issues in a home rarely start as a “big event.” They typically begin as small performance changes that are easy to rationalize:
    a breaker that trips “only sometimes,” lights that dim when the AC kicks on, or an outlet that works “if you wiggle the plug.”
    From a risk-management perspective, those patterns are often early signals of load imbalance, loose terminations, aging devices,
    or circuit-level constraints that no longer match modern demand. A structured approach helps: identify the symptom, isolate the circuit,
    reduce variables (appliances, chargers, power strips), and document what changed (time of day, weather, new appliances, renovation work).
    If the issue repeats, prioritize professional evaluation to minimize escalation and to protect life-safety.
  </p>
  <p>
    For materials and replacement devices, homeowners commonly review availability, ratings, and specs through
    <a href="https://www.homedepot.com/b/Electrical/N-5yc1vZarcd" target="_blank" rel="noopener noreferrer"><strong>Home Depot Electrical</strong>
    and <a href="https://www.lowes.com/c/Electrical" target="_blank" rel="noopener noreferrer"><strong>Lowe&#39;s Electrical</strong></a>,
    while smaller urgent needs are often filled via
    <a href="https://www.acehardware.com/departments/electrical" target="_blank" rel="noopener noreferrer"><strong>Ace Hardware Electrical</strong></a>.
    When the scope is bigger (multi-room remodel, panel coordination, or jobsite procurement), professional supply channels and MRO options like
    <a href="https://www.grainger.com/" target="_blank" rel="noopener noreferrer"><strong>Grainger</strong></a>
    can help maintain consistency in SKUs and specifications.
  </p>
  <p>
    The most frequent operational risk is repeated breaker tripping. A breaker trip is not the “problem” — it is the protective response.
    Repeated trips indicate the circuit is seeing conditions outside normal operating range. Common drivers include: too much load on the same circuit,
    a failing appliance motor, a loose neutral, damaged wiring, or a worn breaker. The homeowner-safe first steps are operational:
    reduce load (unplug nonessential devices), avoid daisy-chained power strips, and note what was running when it tripped.
    If the breaker trips again, stop resetting repeatedly; repeated cycling can stress components and may mask a hazard.
  </p>
  <p>
    Flickering lights can range from simple (loose bulb, incompatible dimmer) to serious (loose termination, service issues).
    If flicker happens across multiple rooms or correlates with large loads (microwave, washer, HVAC), it can indicate broader system strain.
    Warm outlets, discoloration, or burning odors should be treated as priority hazards.
    For safety education, many homeowners reference
    <a href="https://www.esfi.org/" target="_blank" rel="noopener noreferrer"><strong>ESFI</strong></a>
    and for worksite safety principles,
    <a href="https://www.osha.gov/construction" target="_blank" rel="noopener noreferrer"><strong>OSHA Construction</strong></a>.
  </p>
  <p>
    In Tampa Bay, permit and inspection workflows matter. If your repair transitions into modifications or upgrades (new circuits, relocation of devices,
    panel changes), confirm jurisdiction requirements through
    <a href="https://www.tampa.gov/construction-services" target="_blank" rel="noopener noreferrer"><strong>City of Tampa Construction Services</strong></a>
    and
    <a href="https://www.hillsboroughcounty.org/en/businesses/permits-and-records" target="_blank" rel="noopener noreferrer"><strong>Hillsborough County Permits</strong></a>.
    For licensing verification, use
    <a href="https://www.myfloridalicense.com/" target="_blank" rel="noopener noreferrer"><strong>Florida DBPR</strong></a>.
    Good outcomes usually come from pairing the right materials with the right method — and validating both against the project’s scope.
  </p>
</div>',
    2 => '
<div class="topic-block">
  <h3>Deep Dive: Electrical Maintenance Practices That Improve Safety</h3>
  <p>
    Electrical maintenance is best approached as a risk-reduction program rather than a one-time checklist.
    The goal is to identify early wear indicators, stabilize performance, and prevent heat buildup at connection points.
    Maintenance starts with observation: feel for unusual warmth at devices, listen for buzzing, watch for flicker patterns, and track breaker behavior.
    Many hazards are cumulative and become more likely as homes add devices (charging stations, appliances, entertainment systems, smart home hubs).
    A maintenance plan should be simple enough to repeat quarterly, and detailed enough to catch trends.
  </p>
  <p>
    Start at the point-of-use: outlets, switches, cords, and device loads. A loose receptacle that shifts in the wall can stress terminations.
    A damaged cord can arc internally. A power strip overloaded with heaters or kitchen appliances concentrates load into a single point,
    increasing heat risk. Replace worn cords and avoid extension cords as permanent wiring.
    For quality replacement devices and consumables, homeowners frequently compare options via
    <a href="https://www.homedepot.com/" target="_blank" rel="noopener noreferrer"><strong>Home Depot</strong></a>,
    <a href="https://www.lowes.com/" target="_blank" rel="noopener noreferrer"><strong>Lowe&#39;s</strong></a>,
    and
    <a href="https://www.acehardware.com/" target="_blank" rel="noopener noreferrer"><strong>Ace Hardware</strong></a>.
  </p>
  <p>
    GFCI and AFCI devices are core safety layers. Testing schedules matter because a device can fail “quietly.”
    Use the built-in test function per manufacturer guidance. If a device fails to trip or reset properly, replacement is typically appropriate.
    For additional consumer safety guidance, many homeowners reference
    <a href="https://www.esfi.org/" target="_blank" rel="noopener noreferrer"><strong>ESFI</strong></a>.
  </p>
  <p>
    Panel access is a practical safety priority. You need clear, unobstructed access to shut off power during an incident.
    Labeling circuits reduces response time and lowers risk during troubleshooting. If labeling is missing, a structured mapping exercise
    (one breaker at a time, documenting what turns off) can be done safely by a qualified professional or carefully by a homeowner
    with clear protocols. Do not remove the panel cover unless trained; energized components remain hazardous even when a breaker is “off.”
  </p>
  <p>
    Professional inspections add value by identifying conditions hidden from view: loose neutrals, overheated breakers, damaged insulation,
    overloaded circuits, and noncompliant installations. For jurisdiction processes in Tampa Bay, reference
    <a href="https://www.tampa.gov/construction-services" target="_blank" rel="noopener noreferrer"><strong>City of Tampa Construction Services</strong></a>
    and
    <a href="https://www.hillsboroughcounty.org/en/businesses/permits-and-records" target="_blank" rel="noopener noreferrer"><strong>Hillsborough County Permits</strong></a>.
    When maintenance transitions into upgrades, the best outcomes occur when the scope is clearly defined, materials are verified,
    and work is executed to inspection-ready standards.
  </p>
</div>',
    3 => '
<div class="topic-block">
  <h3>Deep Dive: Warning Signs Your Electrical System Needs Attention</h3>
  <p>
    Most electrical failures are preceded by measurable warning signs. Treat these signs as operational signals that your system is approaching
    a performance threshold. The key is to recognize patterns: repeated breaker trips, consistent flicker during load events, outlets that stop working,
    or devices that run unusually hot. The earlier you intervene, the cheaper and safer the fix typically becomes.
  </p>
  <p>
    A common misunderstanding is treating a breaker trip as “annoying” rather than “informational.”
    The breaker is responding to a condition that could otherwise overheat conductors or damage equipment.
    If trips correlate with a specific appliance, the appliance may be failing. If they correlate with general usage, the circuit may be overloaded.
    If there are burning smells, visible discoloration, or audible buzzing, treat it as an immediate hazard and stop using that circuit.
  </p>
  <p>
    Overuse of extension cords is a system-level indicator: not enough outlets, poor circuit distribution, or a space being used in a way
    the original electrical plan did not anticipate. Extension cords are not permanent wiring. If cords are required long-term, the safer
    solution is to evaluate additional outlets/circuits. For planning and product research, use retailer specification hubs like
    <a href="https://www.homedepot.com/b/Electrical/N-5yc1vZarcd" target="_blank" rel="noopener noreferrer"><strong>Home Depot Electrical</strong></a>
    and
    <a href="https://www.lowes.com/c/Electrical" target="_blank" rel="noopener noreferrer"><strong>Lowe&#39;s Electrical</strong></a>.
  </p>
  <p>
    High energy bills without a usage change can reflect inefficient appliances, failing motors, or electrical losses due to poor connections.
    While bill spikes are not always electrical faults, they are a legitimate trigger to evaluate systems.
    A structured approach: verify HVAC filters and operation, check for new loads, and evaluate appliances with unusual behavior.
    For broad homeowner education and safety risk reduction, many reference
    <a href="https://www.esfi.org/" target="_blank" rel="noopener noreferrer"><strong>ESFI</strong></a>
    and
    <a href="https://www.familyhandyman.com/" target="_blank" rel="noopener noreferrer"><strong>Family Handyman</strong></a>.
  </p>
  <p>
    If your home is older, “outdated wiring” can be a real constraint. Upgrading isn’t about appearance—it’s about capacity and safety.
    Any work that involves modifications or upgrades should be coordinated with local permit/inspection requirements.
    For Tampa Bay workflows, reference
    <a href="https://www.tampa.gov/construction-services" target="_blank" rel="noopener noreferrer"><strong>City of Tampa Construction Services</strong></a>
    and
    <a href="https://www.hillsboroughcounty.org/en/businesses/permits-and-records" target="_blank" rel="noopener noreferrer"><strong>Hillsborough County Permits</strong></a>,
    and verify contractor licensing via
    <a href="https://www.myfloridalicense.com/" target="_blank" rel="noopener noreferrer"><strong>Florida DBPR</strong></a>.
  </p>
</div>',
];

/**
 * Expand each blog to include:
 * - existing content
 * - one-page deep-dive block (per id, where provided; fallback generic expansion)
 * - resource block with picture + Video 1 + backlinks
 */
function buildFullContent($id, $title, $baseContent, $expandedMap, $youtubeId){
    $fallbackExpanded = '
<div class="topic-block">
  <h3>Deep Dive: Practical Guidance and Next Steps</h3>
  <p>
    This topic is intended to help homeowners understand the “why” behind common symptoms and what to do next.
    The best outcomes come from combining safe observation (what changed, when it occurs, what loads are present) with timely action.
    If a condition repeats, escalates, or involves heat, odor, discoloration, sparks, or repeated breaker tripping, prioritize professional evaluation.
    Preventive work is typically less expensive than emergency repair and materially reduces safety exposure.
  </p>
  <p>
    For homeowner education and safety best practices, consider referencing
    <a href="https://www.esfi.org/" target="_blank" rel="noopener noreferrer"><strong>ESFI</strong></a>,
    <a href="https://www.thisoldhouse.com/" target="_blank" rel="noopener noreferrer"><strong>This Old House</strong></a>,
    and manufacturer documentation for the exact devices you plan to install.
    For Tampa Bay permitting and inspection workflows, reference
    <a href="https://www.tampa.gov/construction-services" target="_blank" rel="noopener noreferrer"><strong>City of Tampa Construction Services</strong></a>
    and
    <a href="https://www.hillsboroughcounty.org/en/businesses/permits-and-records" target="_blank" rel="noopener noreferrer"><strong>Hillsborough County Permits</strong></a>.
  </p>
</div>';

    $deepDive = $expandedMap[$id] ?? $fallbackExpanded;

    // Extra picture per item (one additional picture beyond the hero image)
    $extraImageUrl = "https://justsmartchoice.com/images/electrical/".$id."_ref.png";

    // Resource block includes video + vendor links
    $resources = resourceBlock($title, $extraImageUrl, $youtubeId);

    // Wrap base content into a block too (for consistent layout)
    return '
<div class="block-wrap">
  <div class="block-content">
    '.$baseContent.'
  </div>
  '.$deepDive.'
  '.$resources.'
</div>';
}

$blogs = [

    // ================= BLOG ID 1 =================
    [
        "id" => 1,
        "title" => "Common Electrical Problems Every Homeowner Should Know",
        "image" => "https://justsmartchoice.com/images/electrical/1.png",
        "content" => "
<h3>Common Electrical Problems Every Homeowner Should Know</h3>

Electrical problems are common in homes and often start with small warning signs. Many homeowners don’t notice these issues until something stops working or becomes a safety concern. Ignoring electrical problems can lead to damage, higher energy bills, or serious hazards.

Understanding common electrical issues helps you act early and keep your home safe. Knowing what to watch for can prevent accidents and costly repairs.
<br><br>

<h3>Frequent Circuit Breaker Trips</h3>

Circuit breakers are designed to shut off power when there is an overload or fault. If a breaker trips occasionally, it’s doing its job. However, frequent tripping usually signals a deeper problem.

This can be caused by overloaded circuits, faulty wiring, or malfunctioning appliances. Repeated breaker trips should never be ignored.
<br><br>

<h3>Flickering or Dimming Lights</h3>

Lights that flicker or dim can be annoying and concerning. While loose bulbs can sometimes be the cause, ongoing flickering often points to wiring issues or overloaded circuits.

If the problem affects multiple lights, it may indicate a larger electrical issue that needs attention.
<br><br>

<h3>Dead Outlets or Switches</h3>

An outlet or switch that suddenly stops working is a common electrical problem. Sometimes the issue is a tripped breaker or a GFCI outlet that needs resetting.

If resetting doesn’t fix the problem, faulty wiring or a damaged outlet may be the cause. Dead outlets should be checked promptly to avoid safety risks.
<br><br>

<h3>Burning Smells or Discolored Outlets</h3>

A burning smell near outlets or switches is a serious warning sign. Discoloration, scorch marks, or melted plastic often indicate overheating or faulty wiring.

These signs should be addressed immediately, as they can lead to electrical fires if ignored.
<br><br>

<h3>Loose or Sparking Outlets</h3>

Outlets that feel loose or produce sparks when plugging in devices can be dangerous. Loose connections allow electricity to arc, increasing the risk of fire.

This issue usually worsens over time and should be repaired as soon as possible.
<br><br>

<h3>Overloaded Power Strips and Extension Cords</h3>

Many homeowners rely heavily on power strips and extension cords, especially in older homes. Plugging too many devices into one outlet can overload the circuit.

Overloading increases the risk of overheating and electrical failure. Permanent wiring solutions are safer than long-term cord use.
<br><br>

<h3>High Electricity Bills Without Explanation</h3>

A sudden increase in electricity bills without changes in usage may point to electrical problems. Faulty wiring or inefficient appliances can consume more power than expected.

Identifying the cause early helps reduce energy waste and costs.
<br><br>

<h3>Outdated or Old Wiring</h3>

Older homes may still have outdated wiring systems that are not designed for modern electrical demands. Aging wires can become brittle and unsafe over time.

Upgrading old wiring improves safety and reduces the risk of electrical failures.
<br><br>

<h3>Warm Switches or Outlets</h3>

Switches or outlets that feel warm to the touch can indicate poor connections or overloaded circuits. While slight warmth can be normal, noticeable heat is not.

Warm electrical components should be inspected before they become a hazard.
<br><br>

<h3>Frequent Light Bulb Burnouts</h3>

Light bulbs that burn out too often may indicate voltage issues or poor connections. This problem can affect both lighting fixtures and appliances.

Addressing the underlying issue helps protect your electrical system and reduce replacement costs.
<br><br>

<h3>Final Thoughts</h3>

Electrical problems often provide warning signs before becoming dangerous. Paying attention to these signs helps keep your home safe and functional.

When electrical issues feel unsafe or unclear, calling a licensed electrician is always the best choice. Early action can prevent serious damage and protect your household.
<br><br>
"
    ],

    // ================= BLOG ID 2 =================
    [
        "id" => 2,
        "title" => "Easy Electrical Maintenance Tips That Improve Safety",
        "image" => "https://justsmartchoice.com/images/electrical/2.png",
        "content" => "<h3>Easy Electrical Maintenance Tips That Improve Safety</h3>

Electrical maintenance plays a major role in keeping your home safe. Many electrical hazards develop slowly and go unnoticed until they become dangerous. Simple maintenance habits can help prevent accidents, electrical fires, and costly repairs.

By paying attention to your electrical system and addressing small issues early, you create a safer living environment for your household.
<br><br>

<h3>Inspect Outlets and Switches Regularly</h3>

Outlets and switches are used every day, which makes them prone to wear over time. Cracks, discoloration, or loose fittings can indicate underlying electrical problems.

Checking them regularly helps you spot potential hazards before they become serious safety concerns.
<br><br>

<h3>Replace Damaged Cords Immediately</h3>

Frayed or damaged cords are a common electrical hazard in homes. Exposed wires can cause shocks, sparks, or even fires if left in use.

Replacing damaged cords right away reduces the risk of accidents and protects your electrical system.
<br><br>

<h3>Test GFCI Outlets</h3>

GFCI outlets are designed to protect against electrical shock, especially in areas like kitchens and bathrooms. Over time, these outlets can fail without obvious signs.

Testing them regularly ensures they are functioning properly and providing the protection they are meant to offer.
<br><br>

<h3>Keep Electrical Panels Clear</h3>

Electrical panels should always be easily accessible. Storing items in front of or around the panel can delay access during emergencies.

Keeping the area clear allows quick shutoff of power and improves overall safety.
<br><br>

<h3>Avoid Overloading Outlets</h3>

Plugging too many devices into one outlet can overload the circuit and cause overheating. This is a common cause of electrical fires in homes.

Spreading electrical loads evenly helps protect wiring and reduces fire risk.
<br><br>

<h3>Use the Correct Light Bulbs</h3>

Using light bulbs with wattage higher than recommended can cause fixtures to overheat. This can damage wiring and increase fire risk.

Always check fixture ratings and use bulbs that match the specified limits.
<br><br>

<h3>Check Extension Cord Usage</h3>

Extension cords are meant for temporary use, not permanent wiring. Using them long-term can increase the risk of overheating and electrical failure.

Replacing extension cords with proper outlets improves safety and reliability.
<br><br>

<h3>Listen for Unusual Electrical Sounds</h3>

Buzzing, crackling, or popping sounds from outlets or switches often indicate loose wiring or faulty connections. These sounds should never be ignored.

Addressing unusual noises early helps prevent dangerous electrical situations.
<br><br>

<h3>Turn Off Power Before DIY Work</h3>

Any electrical work, even small tasks, should be done with the power turned off. Working on live circuits increases the risk of shock and injury.

Taking this simple precaution significantly improves safety during basic maintenance.
<br><br>

<h3>Schedule Professional Electrical Inspections</h3>

Some electrical issues are hidden behind walls and ceilings. Professional inspections can identify problems that are not visible during routine checks.

Regular inspections help ensure your electrical system remains safe and up to standard.
<br><br>

<h3>Final Thoughts</h3>

Maintaining electrical safety doesn’t require advanced skills or expensive upgrades. Small, consistent actions can greatly reduce the risk of electrical hazards.

By following these easy maintenance tips, you can protect your home, your family, and your peace of mind.
<br><br>"
    ],

    // ================= BLOG ID 3 =================
    [
        "id" => 3,
        "title" => "Warning Signs Your Electrical System Needs Attention",
        "image" => "https://justsmartchoice.com/images/plumbing/3.png",
        "content" => "<h3>Warning Signs Your Electrical System Needs Attention</h3>

Electrical problems rarely appear without warning. In most homes, small signs show up long before a serious electrical failure or safety hazard occurs. These signs are often easy to overlook until something stops working or becomes dangerous.

Paying attention to early warning signals can help prevent electrical fires, equipment damage, and unexpected power loss. Knowing what to watch for keeps your home safer.
<br><br>

<h3>Frequent Circuit Breaker Trips</h3>

Circuit breakers are designed to protect your home by shutting off power during overloads or faults. If a breaker trips once in a while, it may not be a concern.

However, repeated tripping usually indicates overloaded circuits, faulty wiring, or failing electrical components that need attention.
<br><br>

<h3>Flickering or Dimming Lights</h3>

Lights that flicker, dim, or brighten unexpectedly often point to wiring problems or loose connections. While a loose bulb can cause flickering, ongoing issues are usually more serious.

If multiple lights are affected, it’s a sign that your electrical system may be under strain.
<br><br>

<h3>Burning Smells or Unusual Odors</h3>

A burning smell near outlets, switches, or the electrical panel is a serious warning sign. It may indicate overheating wires or damaged insulation.

These odors should never be ignored, as they can quickly lead to electrical fires.
<br><br>

<h3>Warm or Discolored Outlets and Switches</h3>

Outlets or switches that feel warm to the touch or show discoloration can signal loose connections or excessive electrical load. Heat buildup increases the risk of damage and fire.

These signs should be checked promptly to ensure safety.
<br><br>

<h3>Sparking or Buzzing Sounds</h3>

Sparks when plugging in devices or buzzing sounds from outlets and switches indicate electrical problems. These symptoms often point to loose wiring or damaged components.

Electrical sparking is dangerous and should be addressed immediately.
<br><br>

<h3>Dead Outlets or Frequent Power Loss</h3>

Outlets that stop working or areas of the home that lose power frequently may be experiencing wiring issues. Sometimes the problem is a tripped breaker or GFCI outlet.

If the issue continues after resetting, professional inspection is recommended.
<br><br>

<h3>Overuse of Extension Cords</h3>

Relying heavily on extension cords can indicate that your home doesn’t have enough outlets. Extension cords are not designed for long-term use.

Overuse can lead to overheating and increased fire risk.
<br><br>

<h3>High Electricity Bills Without Clear Reason</h3>

A sudden increase in energy bills without changes in usage may be linked to electrical inefficiencies or faulty wiring. Damaged systems can draw more power than necessary.

Identifying the cause early helps reduce energy waste and costs.
<br><br>

<h3>Outdated or Aging Wiring</h3>

Older homes may still have wiring systems that are not suitable for modern electrical demands. Aging wires can become brittle and unsafe over time.

Upgrading outdated wiring improves safety and reliability.
<br><br>

<h3>Frequent Light Bulb Burnouts</h3>

Bulbs that burn out too often may signal voltage issues or poor fixture connections. This can affect both lighting and appliances.

Addressing the underlying issue helps protect your electrical system.
<br><br>

<h3>Final Thoughts</h3>

Electrical systems usually provide warning signs before serious problems occur. Recognizing these signs early can prevent hazards and costly repairs.

If you notice any of these issues, contacting a licensed electrician is the safest way to protect your home and family.
<br><br>"
    ],

    // ================= BLOG ID 4 =================
    [
        "id" => 4,
        "title" => "Simple Ways to Prevent Electrical Hazards at Home",
        "image" => "https://justsmartchoice.com/images/electrical/4.png",
        "content" => "<h3>Simple Ways to Prevent Electrical Hazards at Home</h3> ... <br><br>"
    ],

    // ================= BLOG ID 5 =================
    [
        "id" => 5,
        "title" => "Everyday Habits That Can Damage Your Electrical System",
        "image" => "https://justsmartchoice.com/images/electrical/5.png",
        "content" => "<h3>Everyday Habits That Can Damage Your Electrical System</h3> ... <br><br>"
    ],

    // ================= BLOG ID 6 =================
    [
        "id" => 6,
        "title" => "How to Keep Your Drains Clear All Year Long",
        "image" => "https://justsmartchoice.com/images/electrical/6.png",
        "content" => "<h3>How to Keep Your Home Electrically Safe All Year Long</h3> ... <br><br>"
    ],

    // ================= BLOG ID 7 =================
    [
        "id" => 7,
        "title" => "Electrical Safety Tips Every Household Should Follow",
        "image" => "https://justsmartchoice.com/images/electrical/7.png",
        "content" => "<h3>Electrical Safety Tips Every Household Should Follow</h3> ... <br><br>"
    ],

    // ================= BLOG ID 8 =================
    [
        "id" => 8,
        "title" => "Small Electrical Fixes That Make a Big Difference",
        "image" => "https://justsmartchoice.com/images/electrical/8.png",
        "content" => "<h3>Small Electrical Fixes That Make a Big Difference</h3> ... <br><br>"
    ],

    // ================= BLOG ID 9 =================
    [
        "id" => 9,
        "title" => "When to Call an Electrician vs. When You Can DIY",
        "image" => "https://justsmartchoice.com/images/plumbing/9.png",
        "content" => "<h3>When to Call an Electrician vs. When You Can DIY</h3> ... <br><br>"
    ],

    // ================= BLOG ID 10 =================
    [
        "id" => 10,
        "title" => "Smart Electrical Tips to Protect Your Home and Family",
        "image" => "https://justsmartchoice.com/images/electrical/10.png",
        "content" => "<h3>Smart Electrical Tips to Protect Your Home and Family</h3> ... <br><br>"
    ],
    [
    "id" => 11,
    "title" => "Smart Electrical Safety Tips Every Homeowner Should Follow to Prevent Hazards",
    "image" => "https://justsmartchoice.com/images/electrical/11.png",
    "content" => "
<h3>Understanding Common Electrical Hazards</h3>
Electrical hazards can exist in any home, especially in older properties with outdated wiring. Faulty outlets, exposed wires, and overloaded circuits increase risks.

Ignoring small warning signs often leads to serious problems. Sparks, burning smells, and flickering lights should never be overlooked.

Recognizing early warning signs helps prevent dangerous situations.
<br><br>

<h3>Avoiding Overloaded Circuits</h3>
Plugging too many devices into one outlet can overload circuits. This increases the risk of overheating and fire.

Using power strips responsibly and distributing loads properly reduces strain. Electrical balance is important.

Proper load management improves safety.
<br><br>

<h3>Using GFCI Outlets in Wet Areas</h3>
Bathrooms, kitchens, and outdoor areas require GFCI outlets. These outlets shut off power when a fault is detected.

GFCI protection reduces shock risks. Installation in moisture-prone areas is essential.

Upgrading outlets improves protection.
<br><br>

<h3>Inspecting Cords and Appliances Regularly</h3>
Damaged cords create fire hazards. Frayed wires should be replaced immediately.

Regular inspections prevent unexpected failures. Maintenance protects your home.

Routine checks reduce risks.
<br><br>

<h3>Keeping Electrical Panels Updated</h3>
Old panels may not handle modern electrical demands. Overloaded panels increase fire risk.

Upgrading panels improves performance. Safety standards are enhanced.

Panel maintenance ensures reliability.
<br><br>

<h3>Hiring Licensed Electricians</h3>
Electrical work requires professional expertise. DIY mistakes can be dangerous.

Licensed electricians follow safety codes. Proper installation ensures long-term security.

Professional service protects your home.
"
],
[
    "id" => 12,
    "title" => "Expert Advice on Preventing Electrical Overloads and Circuit Failures at Home",
    "image" => "https://justsmartchoice.com/images/electrical/12.png",
    "content" => "
<h3>Understanding Circuit Capacity</h3>
Every circuit has a maximum load capacity. Exceeding this capacity causes overheating.

Homeowners should understand their electrical limits. Knowledge prevents damage.

Load awareness ensures safety.
<br><br>

<h3>Distributing Appliances Properly</h3>
Large appliances require dedicated circuits. Sharing circuits increases failure risk.

Balanced distribution improves efficiency. Performance remains stable.

Strategic placement reduces overload.
<br><br>

<h3>Upgrading Outdated Wiring</h3>
Older wiring systems may not support modern devices. Overheating becomes common.

Replacing outdated wiring improves safety. Efficiency increases.

Modern wiring meets current demands.
<br><br>

<h3>Using Surge Protectors</h3>
Surge protectors guard against voltage spikes. Sensitive electronics remain protected.

Without protection, devices may be damaged. Prevention reduces repair costs.

Protection extends equipment life.
<br><br>

<h3>Monitoring Frequent Breaker Trips</h3>
Frequent breaker trips indicate overload. Ignoring this issue increases fire risk.

Professional assessment identifies root causes. Repairs restore stability.

Breaker behavior should be monitored.
<br><br>

<h3>Scheduling Professional Electrical Inspections</h3>
Regular inspections identify potential overload issues. Preventive maintenance reduces hazards.

Experts evaluate system performance. Early action saves money.

Professional inspections improve safety.
"
],
[
    "id" => 13,
    "title" => "Home Wiring Safety Tips to Avoid Fire Risks and Costly Electrical Repairs",
    "image" => "https://justsmartchoice.com/images/electrical/13.png",
    "content" => "
<h3>Recognizing Signs of Faulty Wiring</h3>
Faulty wiring is one of the leading causes of house fires. Warning signs include flickering lights, buzzing sounds, and burning odors.

Ignoring these symptoms can lead to serious damage. Early detection reduces repair costs.

Recognizing issues quickly protects your home and family.
<br><br>

<h3>Upgrading Old Electrical Systems</h3>
Older homes often have outdated wiring that cannot handle modern appliances. This increases overheating risks.

Upgrading wiring improves safety and performance. Modern systems meet current code requirements.

Electrical updates add long-term reliability.
<br><br>

<h3>Avoiding DIY Wiring Repairs</h3>
Electrical wiring requires professional knowledge. Incorrect connections create serious hazards.

DIY repairs may violate building codes. Mistakes often lead to expensive corrections.

Hiring professionals ensures safe installations.
<br><br>

<h3>Using Proper Wire Insulation</h3>
Insulated wires prevent electrical leakage and shocks. Damaged insulation must be replaced immediately.

Exposure increases fire risks. Regular inspections are essential.

Quality insulation enhances safety.
<br><br>

<h3>Keeping Wiring Away From Moisture</h3>
Moisture weakens electrical systems. Water exposure increases short-circuit risks.

Proper sealing protects wiring. Bathrooms and kitchens need extra care.

Moisture control prevents failures.
<br><br>

<h3>Scheduling Routine Electrical Inspections</h3>
Routine inspections detect hidden wiring problems. Early repairs prevent major damage.

Professional assessments ensure compliance with safety codes. Maintenance improves reliability.

Preventive care reduces long-term costs.
"
],
[
    "id" => 14,
    "title" => "Electrical Panel Upgrade Tips and Advice for Safer and More Efficient Homes",
    "image" => "https://justsmartchoice.com/images/electrical/14.png",
    "content" => "
<h3>Understanding Panel Capacity</h3>
Electrical panels distribute power throughout your home. Outdated panels may not support modern energy needs.

Overloaded panels increase fire hazards. Capacity upgrades improve safety.

Modern panels handle higher electrical demand efficiently.
<br><br>

<h3>Signs Your Panel Needs Replacement</h3>
Frequent breaker trips signal overload. Burning smells or heat around the panel indicate danger.

Rust or corrosion also signals wear. Ignoring these signs increases risk.

Timely replacement ensures reliability.
<br><br>

<h3>Benefits of a Higher Amp Service</h3>
Upgrading to a higher amp service supports more appliances. Performance improves across the home.

Energy distribution becomes more balanced. Safety increases.

Higher capacity prevents overload.
<br><br>

<h3>Improving Energy Efficiency</h3>
New panels distribute power more efficiently. Energy waste is reduced.

Improved systems support modern technology. Performance becomes consistent.

Efficiency lowers long-term costs.
<br><br>

<h3>Meeting Updated Safety Codes</h3>
Electrical codes evolve over time. Upgrades ensure compliance with new regulations.

Code compliance protects homeowners legally. Inspections pass more easily.

Meeting standards enhances protection.
<br><br>

<h3>Professional Panel Installation</h3>
Panel replacement requires licensed electricians. Complex wiring must be handled correctly.

Professional installation prevents mistakes. Safety remains guaranteed.

Expert service ensures long-term performance.
"
],
[
    "id" => 15,
    "title" => "Expert Tips for Installing and Maintaining GFCI Outlets in Wet Areas",
    "image" => "https://justsmartchoice.com/images/electrical/15.png",
    "content" => "
<h3>Understanding GFCI Protection</h3>
GFCI outlets protect against electrical shock. They shut off power when a fault is detected.

These outlets are required in wet areas. Safety standards demand proper installation.

GFCIs prevent serious injuries.
<br><br>

<h3>Where GFCI Outlets Are Required</h3>
Bathrooms, kitchens, garages, and outdoor spaces need GFCIs. Moisture increases shock risks.

Code compliance ensures safety. Proper placement matters.

Correct installation reduces hazards.
<br><br>

<h3>Testing GFCI Outlets Regularly</h3>
GFCI outlets include a test button. Regular testing confirms functionality.

Failure to test may leave outlets unprotected. Routine checks ensure reliability.

Testing enhances safety performance.
<br><br>

<h3>Replacing Faulty GFCI Units</h3>
If outlets fail to reset, replacement is required. Faulty units reduce protection.

Professional replacement ensures proper wiring. Safety is restored.

Timely replacement is important.
<br><br>

<h3>Protecting Outdoor Electrical Systems</h3>
Outdoor outlets face weather exposure. Weatherproof covers enhance durability.

Moisture-resistant components prevent failure. Protection extends lifespan.

Outdoor safety is essential.
<br><br>

<h3>Professional Installation Advantages</h3>
Licensed electricians install GFCIs correctly. Wiring errors are avoided.

Professional service ensures code compliance. Protection remains reliable.

Expert installation guarantees safety.
"
],
[
    "id" => 16,
    "title" => "How to Identify Hidden Electrical Problems Before They Become Dangerous",
    "image" => "https://justsmartchoice.com/images/electrical/16.png",
    "content" => "
<h3>Warning Signs of Hidden Issues</h3>
Hidden electrical issues often show subtle signs. Flickering lights and warm outlets signal problems.

Strange smells or buzzing sounds indicate deeper faults. Ignoring them increases risk.

Early detection prevents emergencies.
<br><br>

<h3>Monitoring Electrical Panel Performance</h3>
Frequent breaker trips may signal wiring issues. Panels should operate smoothly.

Inconsistent performance requires inspection. Timely checks avoid damage.

Panel monitoring improves safety.
<br><br>

<h3>Checking for Overheated Outlets</h3>
Outlets that feel warm may indicate overload. Heat buildup increases fire risk.

Regular inspection ensures safety. Replace damaged outlets promptly.

Heat detection prevents hazards.
<br><br>

<h3>Inspecting Light Fixtures</h3>
Loose connections cause flickering. Improper bulbs may overload fixtures.

Secure fittings improve performance. Routine checks maintain stability.

Fixture maintenance matters.
<br><br>

<h3>Using Thermal Inspection Tools</h3>
Professionals use thermal imaging to detect hidden heat buildup. Invisible issues become visible.

Advanced tools improve diagnostics. Problems are solved early.

Technology enhances inspection accuracy.
<br><br>

<h3>Scheduling Preventive Electrical Evaluations</h3>
Preventive evaluations reduce emergency repairs. Professionals identify risks before damage occurs.

Maintenance improves system reliability. Costs remain controlled.

Routine care ensures long-term safety.
"
],
[
    "id" => 17,
    "title" => "Energy-Saving Electrical Tips to Reduce Utility Bills and Improve Efficiency",
    "image" => "https://justsmartchoice.com/images/electrical/17.png",
    "content" => "
<h3>Switching to Energy-Efficient Lighting</h3>
LED lighting uses less energy than traditional bulbs. Efficiency reduces monthly bills.

Longer lifespan lowers replacement costs. Savings accumulate over time.

Lighting upgrades improve efficiency.
<br><br>

<h3>Installing Smart Thermostats</h3>
Smart thermostats regulate temperature efficiently. Energy waste is minimized.

Automation improves comfort. Control becomes easier.

Technology enhances savings.
<br><br>

<h3>Upgrading to Energy-Efficient Appliances</h3>
Modern appliances consume less electricity. Efficiency ratings guide purchases.

Lower energy use reduces bills. Environmental impact decreases.

Efficient appliances save money.
<br><br>

<h3>Sealing Electrical Gaps</h3>
Air leaks around outlets waste energy. Proper sealing improves insulation.

Energy efficiency increases. Comfort improves.

Sealing reduces loss.
<br><br>

<h3>Using Timers and Automation</h3>
Timers prevent lights from staying on unnecessarily. Automation improves control.

Energy consumption decreases. Convenience increases.

Smart systems reduce waste.
<br><br>

<h3>Professional Energy Audits</h3>
Energy audits identify inefficiencies. Improvements are recommended.

Targeted upgrades maximize savings. Performance improves.

Professional audits deliver results.
"
],
[
    "id" => 18,
    "title" => "Electrical Maintenance Advice to Keep Your Home Safe Year-Round",
    "image" => "https://justsmartchoice.com/images/electrical/18.png",
    "content" => "
<h3>Creating a Maintenance Schedule</h3>
Regular maintenance prevents electrical failures. Scheduled inspections detect early problems.

Consistency reduces emergency repairs. Planning improves reliability.

Routine care enhances safety.
<br><br>

<h3>Testing Smoke and Carbon Monoxide Detectors</h3>
Electrical safety includes detector testing. Batteries and wiring must function properly.

Detectors provide early warnings. Protection increases.

Testing saves lives.
<br><br>

<h3>Inspecting Extension Cords and Power Strips</h3>
Damaged cords increase fire risk. Overused strips may overheat.

Replace worn equipment promptly. Safe usage prevents hazards.

Cord care improves safety.
<br><br>

<h3>Cleaning Electrical Panels Safely</h3>
Dust accumulation affects performance. Panels should remain clean and dry.

Professional cleaning prevents internal damage. Maintenance ensures efficiency.

Clean systems operate better.
<br><br>

<h3>Preparing for Seasonal Electrical Demands</h3>
Heating and cooling seasons increase electrical load. Systems must handle demand safely.

Inspection before peak seasons prevents overload. Preparation improves reliability.

Seasonal planning reduces stress.
<br><br>

<h3>Working With Licensed Electricians for Annual Checkups</h3>
Annual checkups identify hidden risks. Professionals ensure code compliance.

Preventive service reduces long-term costs. Safety remains consistent.

Professional maintenance guarantees peace of mind.
"
]

];

$id = $_GET['id'] ?? 0;
$blog = null;

foreach ($blogs as $b) {
    if ($b['id'] == $id) {
        // Build the fully expanded content (one-page deep dive + resource block + image + video + backlinks)
        $b['content'] = buildFullContent($b['id'], $b['title'], $b['content'], $expanded, $YOUTUBE_VIDEO_ID);
        $blog = $b;
        break;
    }
}

if (!$blog) {
    echo "Blog not found";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $blog['title'] ?> | Just Smart Choice</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root{
    --green:#1fa463;
    --blue:#0b5ea8;
    --light:#f4f9f7;
    --text:#334155;
}

*{margin:0;padding:0;box-sizing:border-box}

body{
    font-family:Segoe UI, Arial, sans-serif;
    background:var(--light);
    color:var(--text);
    padding-top:0;
}

/* ===== HEADER ===== */
.header{
    background:#fff;
    border-bottom:2px solid #e5e7eb;
    position:fixed;
    top:0;
    width:100%;
    z-index:1000;
}
.header-inner{
    max-width:1300px;
    margin:auto;
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.logo{height:48px}
.book{
    background:linear-gradient(90deg,var(--green),var(--blue));
    color:#fff;
    padding:10px 22px;
    border-radius:30px;
    font-weight:bold;
    text-decoration:none;
}

/* ===== HERO ===== */
.hero{
    background:linear-gradient(120deg,var(--green),var(--blue));
    color:#fff;
    padding:45px 20px;
    text-align:center;
}
.hero h1{
    font-size:30px;
    text-shadow:0 4px 12px rgba(0,0,0,.35);
}

/* ===== BLOG CONTENT ===== */
.blog-container{
    max-width:900px;
    margin:60px auto;
    background:#fff;
    padding:35px;
    border-radius:18px;
    box-shadow:0 15px 35px rgba(0,0,0,.1);
}
.blog-container img{
    width:100%;
    border-radius:14px;
    margin-bottom:25px;
}
.blog-container p{
    font-size:16px;
    line-height:1.9;
    white-space:pre-line;
}
.back{
    display:inline-block;
    margin-bottom:20px;
    color:var(--green);
    font-weight:bold;
    text-decoration:none;
}

/* ===== BLOCK SYSTEM ===== */
.block-wrap{margin-top:10px}
.block-content{
    border:1px solid #e5e7eb;
    border-radius:16px;
    padding:18px;
    background:#ffffff;
    box-shadow:0 10px 24px rgba(0,0,0,.06);
}
.topic-block{
    margin-top:18px;
    border:1px solid #e5e7eb;
    border-radius:16px;
    padding:18px;
    background:linear-gradient(180deg,#ffffff,#f8fbff);
    box-shadow:0 10px 24px rgba(0,0,0,.06);
}
.topic-block h3{margin-bottom:10px}
.topic-block p{margin-bottom:12px}

/* ===== RESOURCE BLOCK ===== */
.resource-block{
    margin-top:18px;
    border:1px solid #dbeafe;
    border-radius:18px;
    padding:18px;
    background:#f8fbff;
    box-shadow:0 10px 24px rgba(0,0,0,.06);
}
.resource-head{margin-bottom:14px}
.resource-title{margin-bottom:6px}
.resource-sub{font-size:14px; color:#475569}

.resource-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:14px;
    margin-top:10px;
}
.resource-card{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:14px;
}
.resource-card-title{
    font-weight:800;
    margin-bottom:8px;
    color:#0f172a;
}
.resource-card-text{
    font-size:15px;
    line-height:1.85;
    margin-bottom:10px;
}

.resource-media{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:14px;
    margin-top:14px;
}
.resource-img{
    width:100%;
    border-radius:12px;
    border:1px solid #e5e7eb;
}
.video-wrap{
    position:relative;
    width:100%;
    padding-top:56.25%;
    border-radius:12px;
    overflow:hidden;
    border:1px solid #e5e7eb;
    background:#000;
}
.video-wrap iframe{
    position:absolute;
    top:0;left:0;
    width:100%;
    height:100%;
}
.resource-caption{
    font-size:13px;
    color:#475569;
    margin-top:8px;
    line-height:1.7;
}

.resource-footer{
    margin-top:14px;
    border-top:1px dashed #cbd5e1;
    padding-top:12px;
}
.resource-footer-text{
    font-size:14px;
    color:#334155;
    line-height:1.8;
}

@media(max-width:900px){
    .resource-grid{grid-template-columns:1fr}
    .resource-media{grid-template-columns:1fr}
}

/* ===== FOOTER ===== */
.footer{
    margin:40px auto 20px;
    max-width:1200px;
    border:3px solid var(--green);
    border-radius:18px;
    padding:40px 25px;
}
.footer-inner{
    text-align:center;
}
.footer-logo{height:46px}
.footer-phone{
    font-size:22px;
    font-weight:bold;
    color:var(--green);
}
.footer-bottom{
    margin-top:10px;
    font-size:14px;
    color:#64748b;
}

@media(max-width:768px){
    .hero h1{font-size:24px}
}
</style>
</head>

<body>
<?php include __DIR__ . "/../sections-library/header.php"; ?>

<!-- HEADER -->
<header class="header">
    <div class="header-inner">
        <img class="logo" src="https://crm.justsmartchoice.com/media/public/smartchoice%20logo.png">
        <a href="https://crm.justsmartchoice.com/appointly/appointments_public/book?col=col-md-8+col-md-offset-2" target="_blank" rel="noopener" class="book">BOOK NOW</a>
    </div>
</header>

<!-- HERO -->
<section class="hero">
    <h1><?= $blog['title'] ?></h1>
</section>

<!-- BLOG CONTENT -->
<section class="blog-container">
    <a href="electrical.php" class="back">← Back to Blogs</a>
    <img src="<?= $blog['image'] ?>" alt="<?= htmlspecialchars($blog['title']) ?>">
    <p><?= $blog['content'] ?></p>
</section>

<?php include __DIR__ . "/../sections-library/footer.php"; ?>
</body>
</html>
