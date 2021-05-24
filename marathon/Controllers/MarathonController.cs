using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using MarathonService.Database.Context;
using MarathonService.Models;
using MarathonService.Services;

namespace MarathonService.Controllers
{
  [Route("api/[controller]")]
  [ApiController]
  public class MarathonController : ControllerBase
  {
    private readonly MarathonContext _context;
    private readonly IFriendService _friendService;

    public MarathonController(MarathonContext context, IFriendService friendService)
    {
      _context = context;
      _friendService = friendService;
    }

    // GET: api/Marathon
    [HttpGet]
    public async Task<IEnumerable<Marathon>> GetMarathons()
    {
      return await _context.Marathons.Include(m => m.Participants).ToListAsync();
    }

    // GET: api/Marahon/Friend/0
    [HttpGet("Friend/{userId}")]
    public async Task<IEnumerable<Marathon>> GetFriendMarathons(long userId)
    {
      var friends = await _friendService.GetFriends(userId);
      var ids = friends.Select(friend => friend.FriendId).Append(userId);

      return await _context.Marathons.Where(marathon => ids.Contains(marathon.CreatorId)).Include(m => m.Participants).ToListAsync();
    }

    // GET: api/Marathon/5
    [HttpGet("{id}")]
    public async Task<ActionResult<Marathon>> GetMarathon(long id)
    {
      var marathon = await _context.Marathons.Where(m => m.Id == id).Include(m => m.Participants).FirstAsync();

      if (marathon == null)
      {
        return NotFound();
      }

      return marathon;
    }

    // PUT: api/Marathon/5
    [HttpPut("{id}")]
    public async Task<IActionResult> PutMarathon(long id, Marathon marathon)
    {
      if (id != marathon.Id)
      {
        return BadRequest();
      }

      _context.Entry(marathon).State = EntityState.Modified;

      try
      {
        await _context.SaveChangesAsync();
      }
      catch (DbUpdateConcurrencyException)
      {
        if (!MarathonExists(id))
        {
          return NotFound();
        }
        else
        {
          throw;
        }
      }

      return NoContent();
    }

    // POST: api/Marathon
    [HttpPost]
    public async Task<ActionResult<Marathon>> PostMarathon(MarathonDTO marathonDto)
    {
      var marathon = new Marathon()
      {
        StartDate = marathonDto.StartDate,
        Goal = marathonDto.Goal,
        CreatorId = marathonDto.CreatorId,
      };

      _context.Marathons.Add(marathon);
      await _context.SaveChangesAsync();

      return CreatedAtAction("GetMarathon", new { id = marathon.Id }, marathon);
    }

    // POST: api/Marathon/0/Join?participantId=3
    [HttpPost("{id}/Join")]
    public async Task<ActionResult> JoinMarathon(long id, [FromQuery] long? participantId)
    {
      if (!MarathonExists(id) || participantId == null)
      {
        return NotFound();
      }

      var marathonParticipant = new MarathonParticipant()
      {
        MarathonId = id,
        ParticipantId = (long)participantId,
      };

      _context.MarathonParticipants.Add(marathonParticipant);
      await _context.SaveChangesAsync();

      return NoContent();
    }

    // DELETE: api/Marathon/5
    [HttpDelete("{id}")]
    public async Task<IActionResult> DeleteMarathon(long id)
    {
      var marathon = await _context.Marathons.FindAsync(id);
      if (marathon == null)
      {
        return NotFound();
      }

      _context.Marathons.Remove(marathon);
      await _context.SaveChangesAsync();

      return NoContent();
    }

    private bool MarathonExists(long id)
    {
      return _context.Marathons.Any(e => e.Id == id);
    }
  }
}
